<?php namespace App\Http\Controllers;

use App\Classes\response\Api;
use App\Classes\Validator\validator;
use App\Services\Paginator;
use Hash;
use Auth;
use Illuminate\Http\Request;
use Input;
use App\User;
use JWTAuth;

use Validator as validateRequest;
use App\ArtistPaymentDetail;
use App\PlanMaster;
use App\PaymentDetail;
use App\UserSubscription;

use Stripe;

use DateTime;
use DateTimeZone;

use \PayPal\Rest\ApiContext;
use \PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Plan;
use \PayPal\Api\Agreement;
use \PayPal\Api\Payer;
use Redirect;
class UsersController extends Controller
{

    /**
     * Eloquent User model instance.
     *
     * @var User
     */
    private $model;

    /**
     * Paginator Instance.
     *
     * @var Paginator
     */
    private $paginator;

    public function __construct(User $user, Paginator $paginator)
    {

        $this->model = $user;
        $this->paginator = $paginator;
    }
    /********************
    * Creted By: Anand Jain
    * Created At: 13 Apr 2018 02:30 PM IST
    * Purpose: Create a subscription between artist & user
    ********************/
    public function subscribeArtist(Request $request)
    {
        $obj =  new UserSubscription;
        $data = $obj->getUserAndAgreementDetails(1);
        print_r($data);
        die;
        $user = JWTAuth::parseToken()->authenticate();
        $rules = [
            'type' => 'required|in:paypal,stripe',
            'plan'=>'required|numeric'
        ];
        $input = Input::all();
        $validation = validateRequest::make($input, $rules);
        if ($validation->fails()) {
            $response['errors'] = $validation->errors();
            $response['message'] = 'Invalid data requested.';
            $response['code'] = 400;
            $response['status'] = false;
            return json_encode($response);
        }
        $userId = $user->id;
        $userEmail = $user->email;
        $planId = $input['plan'];
        $pmObj = new PlanMaster();
        $planDetails = $pmObj->getArtistsPlan($planId);
        if (!isset($planDetails->stripe_key)) {
            $response['message'] = 'Invalid plan id.';
            $response['code'] = 400;
            $response['status'] = false;
            return json_encode($response);   
        }
        if ($input['type']=='stripe') {
            if(!isset($input['token'])){
                $response['message'] = 'Token is required to create payment.';
                $response['code'] = 400;
                $response['status'] = false;
                return json_encode($response); 
            }
            $apiKey = $planDetails->stripe_key;
            $stripeId = $planDetails->stripe_id;
            \Stripe\Stripe::setApiKey($apiKey);

            $stripeCustId = $user->stripe_cust_id;
            $stripeToken = $input['token'];

            if (trim($stripeCustId)=='' || $stripeCustId == null) {
                $siteName = env('SITE_NAME') ? env('SITE_NAME') : 'Site Name';
                $customerData = \Stripe\Customer::create(array(
                  "description" => "Customer for ".$siteName." purchasing.",
                  "email" => $userEmail,
                  "source" => $stripeToken // obtained with Stripe.js
                ));
                $cd = $customerData->__toArray();
                $stripeCustId = $cd['id'];      
            }else{
                try {
                    $customerData = \Stripe\Customer::retrieve($stripeCustId);
                } catch (Exception $e) {
                    $customerData = \Stripe\Customer::create(array(
                      "description" => "Customer for ".SHOW_SITE_NAME." purchasing.",
                      "email" => $userEmail,
                      "source" => $stripeToken // obtained with Stripe.js
                    ));
                    $cd = $customerData->__toArray();
                    $stripeCustId = $cd['id'];
                }
            }
            try {
                $data = \Stripe\Subscription::create(array(
                  "customer" => $stripeCustId,
                  "items" => array(
                    array(
                      "plan" => $stripeId
                    ),
                  )
                ));
            } catch (Exception $e) {
                $response['message'] = $e->getMessage();
                $response['code'] = 500;
                $response['status'] = false;
                return json_encode($response); 
            }
            User::where('id', $userId)->update(['stripe_cust_id'=>$stripeCustId]);
            $response['message'] = 'Subscribed successfully !';
            $response['code'] = 200;
            $response['status'] = true;
            return json_encode($response);
        }else if ($input['type']=='paypal') {
            $clientID = $planDetails->paypal_client_id;
            $clientSecret = $planDetails->paypal_client_secret;
            $paypalPlanID = $planDetails->paypal_id;
            $ccd = env('CURRENCY_CODE');
            $mode = env('PAY_ENV');
            $apiContext = new ApiContext(
                new OAuthTokenCredential($clientID, $clientSecret)
            );
            $apiContext->setConfig(
                array(
                    'mode' => $mode
                )
            );
            try {
                $datetime = new DateTime(date('d-m-Y H:i:s'));
                $datetime->setTimezone(new DateTimeZone('Asia/Kolkata'));
                $date = $datetime->format(DateTime::ISO8601);
                $date = explode('+', $date);
                $subStartDate = $date[0].'Z';
                
                $plan = Plan::get($paypalPlanID, $apiContext);
                
                $agreement = new Agreement();
                $agreement->setName($planDetails->plan_name)
                    ->setDescription($planDetails->description)
                    ->setStartDate($subStartDate);
                $newPlan = new Plan();
                $newPlan->setId($plan->getId());
                $agreement->setPlan($newPlan);
                $payer = new Payer();
                $payer->setPaymentMethod('paypal');
                $agreement->setPayer($payer);

                $agreement->create($apiContext);
                $link = $agreement->getApprovalLink();

                $response['code'] = 200;
                $response['approvedLink'] = $link;
                $response['message'] = 'Subscription initiated successfully.';
                $response['status'] = true;
                return json_encode($response);
            } catch (Exception $e) {
                $response['code'] = 500;
                $response['message'] = $e->getMessage();
                $response['status'] = false;
                return json_encode($response);   
            }
        }else{
            $response['message'] = 'Invalid subscription provider.';
            $response['code'] = 400;
            $response['status'] = false;
            return json_encode($response);      
        }
    }
    public function paypalPlanSubscriptionComplete($planId)
    {
        $data = Input::all();
        if (isset($data['success']) && $data['success'] && isset($data['token']) && $data['token'] != '') {
            $pmObj = new PlanMaster();
            $planDetails = $pmObj->getArtistsPlan($planId);
            if (!isset($planDetails->plan_name)) {
                echo "Error"; die;
            }
            $token = $data['token'];
            $clientID = $planDetails->paypal_client_id;
            $clientSecret = $planDetails->paypal_client_secret;
            $paypalPlanID = $planDetails->paypal_id;
            $ccd = env('CURRENCY_CODE');
            $mode = env('PAY_ENV');
            $apiContext = new ApiContext(
                new OAuthTokenCredential($clientID, $clientSecret)
            );
            $apiContext->setConfig(
                array(
                    'mode' => $mode
                )
            );
            $agreement = new Agreement();
            try {
                $agreement->execute($token, $apiContext);
                $agreement = Agreement::get($agreement->getId(), $apiContext);

                $payerInfo = $agreement->payer->payer_info;
                $agreementId = $agreement->id;
                $state = $agreement->state;
                $payerId = $payerInfo->payer_id;    
                $email = $payerInfo->email;
                $status = (strtolower($state)=='active') ? 'succeeded' : strtolower($state);
                $paymentJSON = array(
                    'payId'=>$agreementId,
                    'status'=>$status,
                    'paymentMethod'=>'Paypal',
                    'paymentStatus'=>strtolower($state),
                    'payerEmail'=>$email,
                    'grand_amount'=>$planDetails->amount,
                    'status'=>$status
                );
                $paymentTableData = array(
                    'payment_id'=>$agreementId,
                    'payment_using'=>'Paypal',
                    'payment_data'=>json_encode($paymentJSON)
                );
                $paymentId = PaymentDetail::insertGetId($paymentTableData);
                $userData = User::where('paypal_email', $email)->first();
                if (!isset($userData->id)) {
                    $userId = $userData->id;
                    $dataForSubscription = array(
                        'payment_id'=>$paymentId,
                        'user_id'=>$userId,
                        'plan_id'=>$planId,
                        'is_active'=>0
                    );
                    UserSubscription::where('user_id', $userId)->update(['is_active'=>0]);
                    UserSubscription::insert($dataForSubscription);
                }
               //header('location: '.env('FRONTEND_URL').'/?agreement_id='.$agreementId.'&status=200&message=Payment successfully');
                return Redirect::to(env('FRONTEND_URL').'/?agreement_id='.$agreementId.'&status=200&message=Payment successfully');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }else{
            echo('fasdfa');
        }
    }
}
