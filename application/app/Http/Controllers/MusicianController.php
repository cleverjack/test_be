<?php namespace App\Http\Controllers;

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

}