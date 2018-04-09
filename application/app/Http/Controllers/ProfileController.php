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

class ProfileController extends Controller
{

    private $user;

    public function __construct() {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function getArtistDetail($id){

        
        $artist = Artist::findOrFail($id);
        
        return Api::success(2040,  $artist, ['Artist']);
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
