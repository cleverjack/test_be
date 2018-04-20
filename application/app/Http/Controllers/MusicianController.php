<?php 
namespace App\Http\Controllers;

use App;
use App\Classes\response\Api;
use App\Classes\Validator\validator;
use App\Artist;
use File;
use Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Input;
use JWTAuth;
use Exception;
use Image;

use Validator as validateRequest;
use App\ArtistPaymentDetail;
use App\PlanMaster;
use App\User;
use App\PaymentDetail;

use Stripe;

use \PayPal\Rest\ApiContext;
use \PayPal\Auth\OAuthTokenCredential;
use \PayPal\Api\Plan;
use \PayPal\Api\PaymentDefinition;
use \PayPal\Api\Currency;
use \PayPal\Api\MerchantPreferences;
use \PayPal\Exception\PayPalConnectionException;
use PayPal\Api\Patch;
use PayPal\Common\PayPalModel;
use PayPal\Api\PatchRequest;
use \PayPal\Api\Agreement;
use \PayPal\Api\Payer;

use DateTime;
use DateTimeZone;

class MusicianController extends Controller{
    private $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function authorization(){
        $res = false;
        if($this->user->roles[0]->name == 'artist' || $this->user->roles[0]->name == 'admin'){
            $res = true;
        }
        return Api::success(2040, $res, ["Auth"]);
    }

    public function getArtist(){
        // $artist = "Hello world";
        $artist = $this->user->artists;

        if(count($artist) > 0){
             return Api::success(2040, $artist[0], ["Artist"]);
        }

        return Api::success(2040, $artist, ["No Artist"]);
        
    }

    public function getArtistById($id){
        $artist = Artist::findOrFail($id);
        if(empty($artist)){
            return Api::error(5040, '', ['Artist']);
        }
        return Api::success(2040, $artist, ["No Artist"]);
    }

    public function updateProfile($id){
        //TO DO
        $inputs = Input::all();

        $artist = Artist::with('user')->find($id);

        if (isset($inputs['genres']) && count($inputs['genres']) > 0) {

            $value = $inputs['genres'];
            if (!is_array($value)) {
                $value = [];
            }

            $artist->genres()->sync($value);
        }

        if( isset($inputs['name']) && $inputs['name'] != "undefined"){
            $artist->name = $inputs['name'];
        }

        if( isset($inputs['username']) && $inputs['username'] != "undefined" && $inputs['username'] != "null"){
            $artist->username = $inputs['username'];
        }

        if( isset($inputs['contact']) && $inputs['contact'] != "undefined"){
            $artist->contact = $inputs['contact'];
        }

        if( isset($inputs['location']) && $inputs['location'] != "undefined"){
            $artist->location = $inputs['location'];
        }

        if( isset($inputs['gender']) && $inputs['gender'] != "undefined"){
            $artist->gender = $inputs['gender'];
        }

        if( isset($inputs['website']) && $inputs['website'] != "undefined"){
            $artist->website = $inputs['website'];
        }

        if( isset($inputs['twitter']) && $inputs['twitter'] != "undefined"){
            $artist->twitter = $inputs['twitter'];
        }

        if( isset($inputs['facebook']) && $inputs['facebook'] != "undefined"){
            $artist->facebook = $inputs['facebook'];
        }

        if( isset($inputs['instagram']) && $inputs['instagram'] != "undefined"){
            $artist->instagram = $inputs['instagram'];
        }

        if( isset($inputs['paymentaddress']) && $inputs['paymentaddress'] != "undefined"){
            $artist->payment_address = $inputs['paymentaddress'];
        }

        if( isset($inputs['spotify_popularity']) && $inputs['spotify_popularity'] != "undefined"){
            $artist->spotify_popularity = $inputs['spotify_popularity'];
        }

        if($small_path != ''){
            $artist->image_small = $small_path;
        }

        if($large_path != ''){
            $artist->image_large = $large_path;
        }

        if( isset($inputs['bio']) && $inputs['bio']){
            $artist->bio = $inputs['bio']=="undefined"? '' : $inputs['bio'];
        }

        $artist->save();

        $artist->load('genres');
        
        $user = $this->user;

        if(isset($artist->user[0])){
            if($artist->user[0]->id == $user->id){
                if($small_path != ''){
                    $user->avatar_url = $small_path;
                    $user->save();
                }
            }
        }

        return Api::success(2040, array($user, $artist), ["Artist"]);
    }

    public function savePaidInfo(Request $request){
        $artist = $this->user->artists[0];

        $inputs = Input::all();

        $artist->payment_address = $inputs['address'];
        $artist->monthly_rate = $inputs['price'];
        $artist->locked = $inputs['locked'];
        $result = $artist->save();

        return Api::success(2040, $result, ['Artist']);
    }
    /********************
    * Creted By: Anand Jain
    * Created At: 12 Apr 2018 10:05 AM IST
    * Purpose: Update payment detail of artist
    ********************/
    public function savePaymentInfo(Request $request)
    {
        $rules = [
            'paypal_client_id' => 'required',
            'paypal_client_secret' => 'required',
            'paypal_username' => 'required',
            'paypal_api_password' => 'required',
            'paypal_sign' => 'required',
            'stripe_key' => 'required',
            'stipe_publishable_key' => 'required',
            'paypal_email'=>'required'
        ];
        $artist = $this->user->artists[0];
        $inputs = Input::all();
        $validation = validateRequest::make($inputs, $rules);
        if ($validation->fails()) {
            $response['errors'] = $validation->errors();
            $response['code'] = 400;
            $response['status'] = false;
            return json_encode($response);
        }
        $userId = $artist->pivot['user_id'];
        $userData = User::where('paypal_email', $inputs['paypal_email'])->where('id', '!=', $userId)->first();
        if (isset($userData->id)) {
            $response['code'] = 503;
            $response['message'] = 'Email already registered with another account.';
            $response['status'] = false;
            return json_encode($response);   
        }
        $inputs['artist_id'] = $artist->id;
        $inputs['created_by'] = $artist->id;
        $inputs['created_ip'] = $request->ip();
        $payPalEmail = $inputs['paypal_email'];
        unset($inputs['paypal_email']);
        $payData = ArtistPaymentDetail::where('artist_id', $inputs['artist_id'])->first();
        if (isset($payData->artist_id)) {
            $inputs['updated_ip'] = $inputs['created_ip'];
            $inputs['updated_by'] = $inputs['created_by'];
            unset($inputs['created_by']);
            unset($inputs['created_ip']);
            $data = ArtistPaymentDetail::where('artist_id', $inputs['artist_id'])->update($inputs);
        }else{
            $data = ArtistPaymentDetail::insert($inputs);
        }
        if ($payPalEmail != '') {
            User::where('id', $userId)->update(['paypal_email'=> $payPalEmail]);
        }
        $response['message'] = 'Payment details updated successfully!';
        $response['code'] = 200;
        $response['status'] = true;
        return json_encode($response);
    }
    /********************
    * Creted By: Anand Jain
    * Created At: 12 Apr 2018 01:20 PM IST
    * Purpose: Get payment detail of artist
    ********************/
    public function getPaymentInfo(Request $request)
    {
        $artist = $this->user->artists[0];
        $inputs = Input::all();
        $payData = ArtistPaymentDetail::where('artist_id', $artist->id)->select('paypal_client_id', 'paypal_client_secret', 'paypal_username', 'paypal_api_password', 'paypal_sign', 'stripe_key', 'stipe_publishable_key')->first();
        
        $response['message'] = 'User payment details fetched successfully!';
        $response['data'] = $payData;
        $response['code'] = 200;
        $response['status'] = true;
        
        return json_encode($response);
    }
    /********************
    * Creted By: Anand Jain
    * Created At: 12 Apr 2018 03:15 PM IST
    * Purpose: Save information of plan
    ********************/
    public function savePlanInfo(Request $request)
    {
        $rules = [
            'plan_name' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric|min:1'
        ];
        $messages = [
            'plan_name.required' => 'Plan name field is required.',
            'description.required' => 'Plan description field is required.',
            'amount.required'=>'Plan amount is required.',
            'amount.numeric'=>'Plan amount should be a numeric value.',
            'amount.min'=>'Plan amount can not be less than $1.'
        ];
        $artist = $this->user->artists[0];
        $inputs = Input::all();
        $validation = validateRequest::make($inputs, $rules, $messages);
        if ($validation->fails()) {
            $response['errors'] = $validation->errors();
            $response['code'] = 400;
            $response['status'] = false;
            return json_encode($response);
        }
        $artistId = $artist->id;
        $payData = ArtistPaymentDetail::where('artist_id', $artist->id)->select('paypal_client_id', 'paypal_client_secret', 'paypal_username', 'paypal_api_password', 'paypal_sign', 'stripe_key', 'stipe_publishable_key')->first();
        if (!isset($payData->paypal_client_id)) {
            $response['errors'] = 'Invalid user request';
            $response['code'] = 401;
            $response['status'] = false;
            return json_encode($response);
        }
        $inputs['plan_owner'] = $artist->id;
        $inputs['created_by'] = $artist->id;
        $inputs['created_ip'] = $request->ip();
        $insetedId = PlanMaster::insertGetId($inputs);
        $mode = env('PAY_ENV');
        if ($mode=='sandbox') {
            $apiKey = $payData->stripe_key;
        }else{
            $apiKey = $payData->stripe_key;
        }
        /*Create plan on stripe*/
        try {
            $ccd = env('CURRENCY_CODE');
            \Stripe\Stripe::setApiKey($apiKey);

            $plan = \Stripe\Plan::create(array(
              "amount" => ceil($inputs['amount']) * 100,
              "interval" => "month",
              "name" => $inputs['plan_name'],
              "currency" => $ccd
            ));
            $stripeId = $plan->id;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = 500;
            $response['status'] = true;
            return json_encode($response);
        }
        /*Create plan on Paypal*/
        $clientID = $payData->paypal_client_id;
        $clientSecret = $payData->paypal_client_secret;

        $apiContext = new ApiContext(
            new OAuthTokenCredential($clientID, $clientSecret)
        );
        
        $apiContext->setConfig(
            array( 
                'mode' => $mode 
            )
        );
        $plan = new Plan();
        $plan->setName($inputs['plan_name'])
            ->setDescription($inputs['description'])
            ->setType('INFINITE');
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName($inputs['plan_name'])
            ->setType('REGULAR')
            ->setFrequency('Month') //Day
            ->setFrequencyInterval("1")
            ->setCycles("0")
            ->setAmount(new Currency(array('value' => intval($inputs['amount']), 'currency' => strtoupper($ccd))));
        $merchantPreferences = new MerchantPreferences();
        $baseUrl = url('/');
        $merchantPreferences->setReturnUrl($baseUrl."/paypal-subscription-complete/".$insetedId."?success=true")
            ->setCancelUrl($baseUrl."/paypal-subscription-complete/".$insetedId."?success=false")
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0");
        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);
        $request = clone $plan;
        try{
            $output = $plan->create($apiContext);  
        }catch (PayPalConnectionException $ex){
            $response['message'] = $e->getMessage();
            $response['code'] = 500;
            $response['status'] = true;
            return json_encode($response);
        }
        if (empty($output->getId())) {
            $response['message'] = 'Unknown Error Occure.';
            $response['code'] = 500;
            $response['status'] = true;
            return json_encode($response);
        }
        /*Execute plan and change it's status to Active*/
        try {
            $patch = new Patch();
            $value = new PayPalModel('{
                   "state":"ACTIVE"
                 }');
            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);
            $plan->update($patchRequest, $apiContext);
            $paypalId = $plan->getId(); 
        } catch (Exception $ex) { 
            $response['message'] = $e->getMessage();
            $response['code'] = 500;
            $response['status'] = true;
            return json_encode($response);
        }

        $dataToUpdate['stripe_id'] = $stripeId;
        $dataToUpdate['paypal_id'] = $paypalId;
        $dataToUpdate['is_active'] = 1;

        PlanMaster::where('plan_id', $insetedId)->update($dataToUpdate);

        $response['message'] = 'Plan created successfully!';
        $response['code'] = 200;
        $response['status'] = true;
        return json_encode($response);
    }
    /********************
    * Creted By: Anand Jain
    * Created At: 12 Apr 2018 07:15 PM IST
    * Purpose: Get information of plan
    ********************/
    public function getPlanInfo()
    {
        $artist = $this->user->artists[0];
        $inputs = Input::all();
        $planData = PlanMaster::where('plan_owner', $artist->id)->where('is_active', 1)->select('plan_name', 'description', 'amount', 'created_at')->orderBy('created_at', 'desc')->get();

        $response['message'] = 'User\'s plans detail fetched successfully!';
        $response['data'] = $planData;
        $response['code'] = 200;
        $response['status'] = true;
        
        return json_encode($response);
    }
    /********************
    * Creted By: Anand Jain
    * Created At: 14 Apr 2018 12:30 PM IST
    * Purpose: Create a subscription between artist & web/app
    ********************/
    public function subscribeWeb(Request $request)
    {
        $artist = $this->user->artists[0];
        $rules = [
            'type' => 'required|in:paypal,stripe',
            'plan'=>'required|numeric',
            'plan_name'=>'required',
            'plan_description'=> 'required',
            'amount'=>'required|numeric'
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
        $userId = $artist->pivot['user_id'];
        $artistId = $artist->id;
        $user = User::where('id', $userId)->where('confirmed', 1)->first();
        if (!isset($user->id)) {
            $response['message'] = 'Invalid user.';
            $response['code'] = 400;
            $response['status'] = false;
            return json_encode($response);
        }
        $userEmail = $user->email;
        $planId = $input['plan'];
        if ($input['type']=='stripe') {
            if(!isset($input['stripe_key'])){
                $response['message'] = 'Stripe key is required to create payment.';
                $response['code'] = 400;
                $response['status'] = false;
                return json_encode($response); 
            }
            if(!isset($input['stripe_id'])){
                $response['message'] = 'Stripe ID is required to create payment.';
                $response['code'] = 400;
                $response['status'] = false;
                return json_encode($response); 
            }
            if(!isset($input['token'])){
                $response['message'] = 'Token is required to create payment.';
                $response['code'] = 400;
                $response['status'] = false;
                return json_encode($response); 
            }
            $apiKey = env('STRIPE_KEY');
            $stripeId = $input['stripe_id'];
            \Stripe\Stripe::setApiKey($apiKey);

            $stripeCustId = $artist->stripe_cust_id;
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
                    $siteName = env('SITE_NAME') ? env('SITE_NAME') : 'Site Name';
                    $customerData = \Stripe\Customer::create(array(
                      "description" => "Customer for ".$siteName." purchasing.",
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
            $subscriptionId = $data->id;
            $status =  'succeeded';
            $paymentJSON = array(
                'payId'=>$subscriptionId,
                'status'=>$status,
                'paymentMethod'=>'Stripe',
                'paymentStatus'=>strtolower($status),
                'payerEmail'=>$userEmail,
                'grand_amount'=>$input['amount'],
                'status'=>$status
            );
            $paymentTableData = array(
                'payment_id'=>$subscriptionId,
                'payment_using'=>'Stripe',
                'payment_data'=>json_encode($paymentJSON),
                'created_ip' =>$request->ip()
            );
            PaymentDetail::insert($paymentTableData);
            Artist::where('id', $artistId)->update(['stripe_cust_id'=>$stripeCustId]);
            $response['message'] = 'Subscribed successfully !';
            $response['code'] = 200;
            $response['status'] = true;
            return json_encode($response);
        }else if ($input['type']=='paypal') {
            if(!isset($input['paypal_id'])){
                $response['message'] = 'Plan\'s PayPal ID is required to create payment.';
                $response['code'] = 400;
                $response['status'] = false;
                return json_encode($response); 
            }
            $clientID = env('PAYPAL_CLIENT_ID');
            $clientSecret = env('PAYPAL_CLIENT_SECRET');
            $paypalPlanID = $input['paypal_id'];
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
                $agreement->setName($input['plan_name'])
                    ->setDescription(strip_tags($input['description']))
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
}