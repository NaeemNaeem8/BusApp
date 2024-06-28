<?php

namespace App\Interfaces\LoginMethods;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserLoginStrategy implements LoginInterface
{
    public function login(array $data)
    {
        $user = User::whereEmail($data['email'])->firstOrFail();

        if (Hash::check($data['password'], $user->password) && $user->confirmed) {
            $token = $user->createToken('token-name', ['users'])->plainTextToken;
            return $token;
        } else
            return false;
    }
}
