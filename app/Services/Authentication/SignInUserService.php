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
            throw new UserWrongCredentials(__('auth.failed'), 401);
        }
        return $user;
    }
}
