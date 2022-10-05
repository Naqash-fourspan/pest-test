<?php

namespace App\Http\Services\Auth;

use App\Models\User;

class UserService
{
    public function createUser(array $postData)
    {
        $postData['password'] = bcrypt($postData['password']);
        $postData['email_verified_at'] = null;
        $user = User::create($postData);

        return $user;
    }
}
