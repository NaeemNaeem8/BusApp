<?php

namespace App\Interfaces\LoginMethods;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminLoginStrategy implements LoginInterface
{
    public function login(Array $data)
    {
        $admin = Admin::whereEmail($data['email'])->firstOrFail();

        if (!Hash::check($data['password'], $admin->password))
            return false;

        $token = $admin->createToken('token-name')->plainTextToken;

        return $token;
    }
}
