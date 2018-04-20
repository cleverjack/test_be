<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Stripe;
use Illuminate\Http\Request;
use App\User;
use App\PlanMaster;
use App\PaymentDetail;
use App\UserSubscription;

class WebhookController extends Controller {
	/********************
  * Creted By: Anand Jain
  * Created At: 20 Apr 2018 03:15 PM IST
  * Purpose: Handle webhook for subscription via stripe
  ********************/
	public function stripeWebhookHandler(Request $request)
	{
		$input = @file_get_contents("php://input");
		$event_json = json_decode($input);
		$userData = User::getUserDetails($event->data->object->customer);
		if (!isset($userData->role_id)) {
			return "Invalid user details.";
			die();
		}
		if (!isset($userData->id)) {
			return "Invalid user details.";
			die();
		}
		if ($userData->role_id == 3) {
			$planId = (isset($event_json->data) && isset($event_json->data->object) && isset($event_json->data->object->lines) && isset($event_json->data->object->lines->data) && isset($event_json->data->object->lines->data->plan->id)) ? $event_json->data->object->lines->data->plan->id : 0;
			$obj = new PlanMaster();
			$plandData = $obj->getPlanByStripeId($planId);
			if (isset($planData->stripe_id)) {
				$apiKey = $plandData->stripe_key;
			}else{
				$apiKey = env('STRIPE_KEY');
			}
		}else{
			$apiKey = env('STRIPE_KEY');
		}

		\Stripe\Stripe::setApiKey($apiKey);
		try {
			$event = \Stripe\Event::retrieve($event_json->id);
		} catch (Exception $e) {
			return $e->getMessage();
 			die();
		}
		
		$userId = $userData->id;
		if (isset($event) && $event->type=='invoice.payment_succeeded') { 
			$subscriptionId = $event->data->object->subscription;
			$subscriptionData = PaymentDetail::where('payment_id', $subscriptionId)->where('payment_using', 'stripe')->first();
			if (!isset($subscriptionData->pay_id)) {
				return "Invalid payment data.";
 				die();
			}
			$planDetails = \Stripe\Subscription::retrieve($subscriptionId);
			if (!isset($planDetails) || !isset($planDetails->plan)) {
				return "Invalid subscription plan details.";
				die();
			}
			$planId = $planDetails->plan->id;
			$planData = PlanMaster::where('stripe_id', $planId)->where('is_active', 1)->first();
			if (!isset($planData->plan_id)) {
				return "Invalid plan.";
				die();
			}
			PaymentDetail::where('payment_id', $subscriptionId)->where('payment_using', 'stripe')->update(['payment_status'=>'completed', 'updated_ip'=>$request->ip()]);
			$planDetails = $planDetails->__toArray();
			$data = array(
				'payment_id'=>$subscriptionId,
				'payment_using'=>'stripe',
				'payment_status'=>'success',
				'payment_data'=>json_encode($planDetails),
				'created_ip'=>$request->ip()
			);
			$paymentId = PaymentDetail::insertGetId($data);
			$dataForSubscription = array(
				'payment_id'=>$paymentId,
				'user_id'=>$userId,
				'plan_id'=>$planId,
				'is_active'=>1,
				'next_payment_date'=>date("Y-m-d H:i:s", $planDetails['current_period_end']),
			);
			UserSubscription::where('user_id', $userId)->update(['is_active'=>0]);
			UserSubscription::insert($dataForSubscription);
			return "Subscription updated successfully !";
		}else if (isset($event) && $event->type=='invoice.payment_failed') { 
			/*For unsuccessfull payment/renew*/
			$subscriptionId = $event->data->object->subscription;
			$planDetails = \Stripe\Subscription::retrieve($subscriptionId);
			if (!isset($planDetails) || !isset($planDetails->plan)) {
				return "Invalid subscription plan details.";
				die();
			}
			$planId = $planDetails->plan->id;
			$planData = PlanMaster::where('stripe_id', $planId)->first();
			if (!isset($planData->plan_id)) {
				return "Invalid plan.";
				die();
			}
			UserSubscription::where('user_id', $userId)->update(['is_active'=>0]);
			return "User subscription renew failed.";
		}else {
			return "Event not handled in webhook.";
		}
		print_r($event_json);
	}
	/********************
  * Creted By: Anand Jain
  * Created At: 20 Apr 2018 12:15 PM IST
  * Purpose: Handle webhook for subscription via paypal
  ********************/
  public function paypalWebhookHandler(Request $request)
  {
  	$input = @file_get_contents("php://input");
 		$event = json_decode($input);
 		if (isset($event) && $event->event_type=='PAYMENT.SALE.COMPLETED') {
 			$subscriptionId = $event->resource->billing_agreement_id;
 			$patmentDetails = PaymentDetail::where('payment_id', $subscriptionId)->where('payment_status', 'initiated')->first();
 			if (!isset($patmentDetails->payment_id)) {
 				return "Payment Details not found.";
 			}
 			$paymentData = json_decode($paymentDetails->payment_data);
 			if (!is_object($payment_data)) {
 				return "Invalid payment details.";
 			}
 			$email = $paymentData->payerEmail;
 			$userData = User::where('paypal_email', $email)->first();
 			if (!isset($userId->id)) {
 				return "User data not found.";
 			}
 			$userId = $userData->id;
 			PaymentDetail::where('pay_id', $patmentDetails->pay_id)->where('payment_using', 'paypal')->update(['payment_status'=>'completed', 'updated_ip'=>$request->ip()]);
 			$data = array(
				'payment_id'=>$subscriptionId,
				'payment_using'=>'paypal',
				'payment_status'=>'success',
				'payment_data'=>json_encode($patmentDetails->payment_data),
				'created_ip'=>$request->ip()
			);
			$paymentId = PaymentDetail::insertGetId($data);
 			$dataForSubscription = array(
				'payment_id'=>$paymentId,
				'user_id'=>$userId,
				'plan_id'=>$paymentData->planId,
				'is_active'=>1,
				'next_payment_date'=>date("Y-m-d H:i:s", strtotime('+1 months'))
			);
			UserSubscription::where('user_id', $userId)->update(['is_active'=>0]);
			UserSubscription::insert($dataForSubscription);
			return "Subscription updated successfully !";
 		}else if (isset($event) && ($event->event_type=='PAYMENT.SALE.DENIED')) {
			/*For unsuccessfull payment/renew*/
			$subscriptionId = $event->resource->billing_agreement_id;
			$patmentDetails = PaymentDetail::where('payment_id', $subscriptionId)->first();
 			if (!isset($patmentDetails->payment_id)) {
 				return "Payment Details not found.";
 			}
 			$paymentData = json_decode($paymentDetails->payment_data);
 			if (!is_object($payment_data)) {
 				return "Invalid payment details.";	
 			}
 			$email = $paymentData->payerEmail;
 			$userData = User::where('paypal_email', $email)->first();
 			if (!isset($userId->id)) {
 				return "User data not found!";
 			}
 			$userId = $userData->id;
			UserSubscription::where('user_id', $userId)->update(['is_active'=>0]);
			return "User subscription renew failed.";
 		}else{
			return "Event not handled in webhook.";
 			die();
		}
  }

  public function stripeConnectTest()
  {
  	\Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
		\Stripe\Stripe::setApiVersion(env('STRIPE_API_VERSION'));
		$acct = \Stripe\Account::create(array(
		    "country" => "US",
		    "type" => "custom",
		    "email" => "sonu.chapter247@gmail.com"
		));
		$acD = \Stripe\Account::all(array("limit" => 100));
		print_r($acD->__toArray());
  }
}