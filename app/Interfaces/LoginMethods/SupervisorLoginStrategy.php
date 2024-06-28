<?php

namespace App\Interfaces\LoginMethods;

use App\Models\Supervisor;
use Illuminate\Support\Facades\Hash;

class SupervisorLoginStrategy implements LoginInterface
{
    public function login(array $data)
    {
        $supervisor = Supervisor::whereEmail($data['email'])->firstOrFail();

        if (!Hash::check($data['password'], $supervisor->password))
            return false;

        $token = $supervisor->createToken('token-name')->plainTextToken;

        return $token;
    }
}
