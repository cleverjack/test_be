<?php namespace App\Http\Controllers;

use App\Classes\response\Api;
use App\Classes\Validator\validator;
use App\Services\Paginator;
use Hash;
use Auth;
use Illuminate\Http\Request;
use Input;
use App\User;
use JWTAuth;

class UsersController extends Controller
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

    public function __construct(User $user, Paginator $paginator)
    {
        $this->model = $user;
        $this->paginator = $paginator;
    }
}
