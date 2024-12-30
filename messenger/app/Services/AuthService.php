<?php

namespace App\Services;

use App\Base\Packages\ServiceWrapper;
use Illuminate\Http\Request;

class AuthService
{
    public function LoginUser(Request $request)
    {
        return app(ServiceWrapper::class)(function() use($request) {
            if(!auth()->attempt($request->validated()))
                return ["action" => "wrong username or password!", "status" => 401];
            $user = auth()->user();
            $token = $user->createToken($request->header('User-Agent'))->plainTextToken;
            return [
                "action" => [
                    "email" => $user->email,
                    "accessToken" => $token,
                    "username" => $user->username,
                    "user_id" => $user->id,
                    "img" => $user->img,
                ],
                "status" => 200,
            ];
        });
    }

    public function LogoutUser()
    {
        return app(ServiceWrapper::class)(function() {
            return [
                "action" => auth()->user()->currentAccessToken()->delete(),
                "status" => 200,
            ];
        });
    }
}
