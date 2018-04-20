<?php namespace App\Http\Controllers;

use App;
use App\Classes\response\Api;
use Cache;
use Input;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use App\Artist;
use App\User;
use Image;
use App\ArtistPaymentDetail;
use App\PlanMaster;
use App\UserSubscription;

class ProfileController extends Controller
{

    private $user;

    public function __construct() {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function getArtistDetail($id){
        $artist = Artist::findOrFail($id);
        $payementDetails = collect([]);
        $planDetails = collect([]);
        if (isset($artist->id)) {
            $payementDetails = ArtistPaymentDetail::where('artist_id', $artist->id)->select('stipe_publishable_key')->first();
            $planDetails = PlanMaster::where('plan_owner', $artist->id)->where('is_active', 1)->select('plan_id','plan_name', 'description', 'amount', 'created_at')->first();
            
            if (isset($planDetails->plan_id)) {
                $userId = $this->user->id;        
                $isSubscribed = UserSubscription::where('plan_id', $planDetails->plan_id)->where('user_id', $userId)->where('is_active', 1)->select('subscription_id')->first();
                if (isset($isSubscribed->subscription_id)) {
                    $planDetails->isSubscribed = true;
                }else{
                    $planDetails->isSubscribed = false;
                }
            }
        }
        $data['artist'] = $artist;
        $data['payementDetails'] = $payementDetails;
        $data['planDetails'] = $planDetails;
        return Api::success(2040,  $data, ['Artist']);
    }

    public function getListenerSelfData(){
        $listener = $this->user;
        return Api::success(2040, $listener, 'Listener');
    }

    public function getListenerDetail($id){
        $listener = User::findOrFail($id);
        return Api::success(2040, $listener, ['Listener']);
    }

    public function getArtists(){
        $artists = Artist::with('user')->get();
        return Api::success(2040, $artists, ['Artists']);
    }
}
