<?php


use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'store']);
Route::delete('auth/logout', [AuthController::class, 'destroy'])->middleware(['auth:sanctum']);
