<?php

namespace App\Http\Controllers\User;

use App\Base\Packages\ImgUpload;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserDeleteRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function index()
    {
        return $this->userService->UserContacts();
    }

    public function store(UserStoreRequest $request)
    {
        return $this->userService->RegisterUser(ImgUpload::perform($request,'user'));
    }

    public function show(string $username)
    {
        return $this->userService->UserDetails($username);
    }

    public function update(UserUpdateRequest $request, string $username)
    {
        return $this->userService->UpdateUser(
            ImgUpload::perform($request, 'user', User::where('username', $username)->firstOrFail()),
            $username,
        );
    }

    public function destroy(UserDeleteRequest $request, string $username)
    {
        return $this->userService->DeleteUser($username);
    }

    public function delUserImg(string $username)
    {
        return $this->userService->DeleteUserImage($username);
    }

    public function search()
    {
        return $this->userService->SearchInUsers();
    }
}
