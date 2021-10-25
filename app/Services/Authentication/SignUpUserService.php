<?php

namespace App\Services\Authentication;

use App\Models\User;

class SignUpUserService
{
    public function execute($array) {
        return User::create([
            'name' => $array['name'],
            'password' => bcrypt($array['password']),
            'email' => $array['email']
        ]);
    }
}
