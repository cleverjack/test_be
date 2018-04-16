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
  * Created At: 16 Apr 2018 03:15 PM IST
  * Purpose: Handle webhook for subscription
  ********************/
	public function stripeWebhookHandler(Request $request)
	{
		$input = @file_get_contents("php://input");
		$event_json = json_decode($input);
		$apiKey = env('STRIPE_KEY');
		\Stripe\Stripe::setApiKey($apiKey);
		try {
			$event = \Stripe\Event::retrieve($event_json->id);
		} catch (Exception $e) {
			return $e->getMessage();
 			die();
		}
		$userData = User::where('stripe_cust_id', $event->data->object->customer)->where('confirmed', 1)->first();
		if (!isset($userData->id)) {
			return "Invalid user details.";
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
  * Created At: 17 Apr 2018 12:15 PM IST
  * Purpose: Handle webhook for subscription
  ********************/
  public function paypalWebhookHandler(Request $request)
  {
  	$input = @file_get_contents("php://input");
 		$event = json_decode($input);
 		if (isset($event) && $event->event_type=='PAYMENT.SALE.COMPLETED') {
 			$subscriptionId = $event->resource->billing_agreement_id;

 		}else if (isset($event) && ($event->event_type=='PAYMENT.SALE.DENIED')) {

 		}else{
			//$this->common_model->insert('temp_files', array('directoryURL'=>json_encode($event)));
			return "Event not handled in webhook.";
 			die();
		}
  }
}