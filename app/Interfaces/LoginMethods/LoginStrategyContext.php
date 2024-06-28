<?php

namespace App\Interfaces\LoginMethods;

use Illuminate\Database\Eloquent\Model;

class LoginStrategyContext
{
    private LoginInterface $strategy;
    public function __construct(string $login)
    {
        $this->strategy = match ($login) {
            'users'              => new UserLoginStrategy(),
            'admins'             => new AdminLoginStrategy(),
            'supervisors'        => new SupervisorLoginStrategy(),
            'drivers'            => new DriverLoginStrategy(),
            default              => false
        };
    }

    public function login(array $data)
    {
        return $this->strategy->login($data);
    }
}
