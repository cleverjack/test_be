<?php namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class PlanMaster extends Model {

	//
	protected $table = 'plan_master';
	/********************
  * Creted By: Anand Jain
  * Created At: 13 Apr 2018 03:45 PM IST
  * Purpose: Get details of artist, plan and his payment credentials
  ********************/
	public function getArtistsPlan($planId)
	{
		return DB::table('plan_master as pm')
								->join('artists as a', 'a.id', '=', 'pm.plan_owner')
								->join('artist_payment_details as apd', 'apd.artist_id', '=', 'a.id')
								->where('pm.plan_id', $planId)
								->where('pm.is_active', 1)
								->select('pm.plan_name', 'pm.description', 'pm.amount', 'pm.plan_owner', 'apd.stripe_key', 'pm.stripe_id', 'pm.paypal_id', 'apd.paypal_client_id', 'apd.paypal_client_secret')
								->first();
	}
}
