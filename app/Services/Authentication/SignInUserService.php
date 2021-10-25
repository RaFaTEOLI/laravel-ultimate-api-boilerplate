<?php

namespace App\Services\Authentication;

use App\Exceptions\UserWrongCredentials;
use Illuminate\Support\Facades\Auth;

class SignInUserService
{
    public function execute($array) {
        if (!Auth::attempt($array)) {
            throw new UserWrongCredentials('Credentials do not match', 401);
        }
    }
}
