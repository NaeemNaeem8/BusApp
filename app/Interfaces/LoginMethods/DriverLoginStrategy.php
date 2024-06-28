<?php

namespace App\Interfaces\LoginMethods;

use App\Models\Driver;
use Illuminate\Support\Facades\Hash;

class DriverLoginStrategy implements LoginInterface
{
    public function login(array $data)
    {
        $driver = Driver::whereEmail($data['email'])->firstOrFail();

        if (!Hash::check($data['password'], $driver->password))
            return false;

        $token = $driver->createToken('token-name')->plainTextToken;

        return $token;
    }
}
