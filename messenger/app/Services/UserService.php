<?php

namespace App\Services;

use App\Base\Packages\ServiceWrapper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService
{
    public function UserContacts(): bool
    {
        return true;
    }

    public function RegisterUser(array $inputs)
    {
        return app(ServiceWrapper::class)(function() use($inputs) {
            $inputs['password'] = Hash::make($inputs['password']);
            $user = User::create($inputs);
            return ["action" => $user, "status" => 200];
        });
    }

    public function UserDetails(string $username)
    {
        return app(ServiceWrapper::class)(
            fn() => [
                "action" => User::where('username', $username)->firstOrFail(),
                "status" => 200,
            ]
        );
    }

    public function UpdateUser(array $inputs, string $username)
    {
        return app(ServiceWrapper::class)(function() use($inputs, $username) {
            $user = User::where('username', $username)->firstOrFail();
            return ["action" => $user->update($inputs), "status" => 200];
        });
    }

    public function DeleteUser(string $username)
    {
        return app(ServiceWrapper::class)(function() use($username) {
            $user = User::where('username', $username)->firstOrFail();
            ImgDelete::perform($user, 'user');
            return ["action" => $user->delete(), "status" => 200];
        });
    }

    public function DeleteUserImage(string $username)
    {
        return app(ServiceWrapper::class)(function() use($username) {
            $user = User::where('username', $username)->firstOrFail();
            return ["action" => ImgDelete::perform($user, 'user'), "status" => 200];
        });
    }

    public function SearchInUsers()
    {
        return app(ServiceWrapper::class)(function() {
            $search_phrase = strtolower(request()->input('q'));
            $results = User::where('username', 'like', "%$search_phrase%")
                ->orWhere('name', 'like', "%$search_phrase%")->get();
            return ["action" => $results, "status" => 200];
        });
    }
}
