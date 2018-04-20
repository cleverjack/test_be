<?php

namespace App\Http\Controllers;

use App\Classes\Auth\Auth;
use App\Classes\response\Api;
use App\Classes\Validator\validator;
use App\Services\Paginator;

use App\Repositories\ActivationRepository;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Mailgun;
use Sendgrid;

use App\User;
use App\Role;
use App\Artist;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Input;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UsersAuthController extends Controller
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

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function loginUser(Request $request, $code = 2010, $message = [])
    {

        $defaultInputs = array(
            'email' => null,
        );

        $rules = array(
            'email' => 'required|email',
        );

        $inputs = validator::validate($defaultInputs, $rules);

        if (isset($inputs['success']) && $inputs['success'] === false) {
            return $inputs;
        }

        $userInfo = User::where('email', $inputs['data']['email'])->first();
        if (empty($userInfo)) {
            return Api::error(3040, array('inputs' => $userInfo), array('Email'));
        }

        // grab credentials from the request
        $credentials = $request->only(['email', 'password']);

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return Api::error(3090, [], ['Password incorrect']);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return Api::error(5010, [], ['Token creation']);
        }

        // all good so return the token
        $user = JWTAuth::setToken($token)->authenticate();
        $user['token'] = 'Bearer ' . $token;
        $user['permission'] = $user->roles[0]->name;
        return Api::success($code, $user, $message);
    }
    /**
     * @return string
     */
    public function logOut()
    {
        JWTAuth::parseToken()->invalidate();
        return Api::success(6000, [], ['You have successfully logged out']);
    }
}