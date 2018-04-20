<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model {
	/********************
  * Creted By: Anand Jain
  * Created At: 16 Apr 2018 12:30 PM IST
  * Purpose: Get user and agreement details
  ********************/
	public function getUserAndAgreementDetails($agreementId)
	{
		return $this->hasMany('App\PaymentDetail', 'payment_id', 'pay_id')->first();
	}
}
