<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserSubscription extends Model {

	//
	public function getUserAndAgreementDetails($agreementId)
	{

		return $this->hasMany('App\PaymentDetail', 'payment_id', 'pay_id')->first();
	}
}
