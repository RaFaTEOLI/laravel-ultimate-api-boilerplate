<?php

namespace App\Services\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class CreateUserService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function execute(array $request)
    {
        try {
            $request["password"] = Hash::make($request["password"]);
            // Saves the User
            $user = User::create($request);

            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
