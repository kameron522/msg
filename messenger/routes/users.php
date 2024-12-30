<?php

use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\User\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;



Route::middleware(['ttl:60'])->prefix('users/')->group(function() {
    Route::get('search', [UserController::class, 'search']);
    Route::post('', [UserController::class, 'store']);
    Route::get('contacts', [UserController::class, 'index'])->middleware(['auth:sanctum']);
    Route::get('{username}', [UserController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'ttl:60'])->prefix('users/{username}/')->group(function() {
    Route::patch('', [UserController::class, 'update']);
    Route::delete('', [UserController::class, 'destroy']);
    Route::delete('del-user-img', [UserController::class, 'delUserImg']);
});

Route::get('users/{username}/chats', [MessageController::class, 'chat'])->middleware(['auth:sanctum']);

