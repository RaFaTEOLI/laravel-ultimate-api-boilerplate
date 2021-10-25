<?php

namespace App\Services\Authentication;

use App\Exceptions\UserWrongCredentials;
use Illuminate\Support\Facades\Auth;

class SignInUserService
{
    public function execute($array)
    {
        $user = Auth::attempt($array);
        if (!$user) {
            throw new UserWrongCredentials('Credentials do not match', 401);
        }
        return $user;
    }
}
