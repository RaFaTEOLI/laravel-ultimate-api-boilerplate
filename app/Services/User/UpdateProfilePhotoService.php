<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;

class UpdateProfilePhotoService
{
    public function execute($userId, array $input)
    {
        try {
            $user = User::find($userId);

            Validator::make($input, [
                'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:3072'],
            ])->validateWithBag('updateProfileInformation');

            if (isset($input['photo'])) {
                $user->updateProfilePhoto($input['photo']);
            }

            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
