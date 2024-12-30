<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function store(LoginRequest $request)
    {
        return $this->authService->LoginUser($request);
    }

    public function destroy()
    {
        return $this->authService->LogoutUser();
    }
}
