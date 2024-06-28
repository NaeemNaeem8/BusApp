<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\LoginMethods\LoginStrategyContext;
use App\Models\User;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $loginStrategy = new LoginStrategyContext($request->type);

        $token =  $loginStrategy->login($request->validated());

        if (!$token) return response()->error('try agin', 401);

        return response()->success($token);
    }

    public function register(RegisterRequest $request)
    {
        User::create($request->get_data());
        return response()->success('', 'Register successfully');
    }
}
