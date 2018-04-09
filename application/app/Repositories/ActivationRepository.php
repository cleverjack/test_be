<?php namespace App\Repositories;

use App\RegisterRepository;
use Carbon\Carbon;
use Illuminate\Database\Connection;

class ActivationRepository
{

    public function getActivation($user)
    {
        return RegisterRepository::where('email', $user['email'])->first();
    }

    public function getActivationByToken($token)
    {
        return RegisterRepository::where('token', $token)->first();
    }

    public function deleteActivation($token)
    {
        RegisterRepository::where('token', $token)->delete();
    }

    public function createActivation($user)
    {
        $activation = $this->getActivation($user);

        if (!$activation) {
            return $this->createToken($user);
        }
        return $this->regenerateToken($user);
    }

    protected function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    private function regenerateToken($user)
    {
        $token = $this->getToken();
        RegisterRepository::where('email', $user['email'])->update([
            'token' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;
    }

    private function createToken($user)
    {
        $token = $this->getToken();
        RegisterRepository::insert([
            'name' => $user['name'],
            'email' => $user['email'],
            'type' => $user['type'],
            'token' => $token,
            'created_at' => new Carbon(),
            'gender'=> $user['info']['gender'],
            'birth'=> $user['info']['birth'],
            'password'=> $user['info']['password'],
            'first_name'=> $user['info']['firstname'],
            'last_name'=> $user['info']['lastname']           
        ]);
        return $token;
    }
}