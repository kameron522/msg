<?php

use App\Http\Controllers\Message\MessageController;
use App\Models\Message;
use Illuminate\Support\Facades\Route;


// for test
//Route::get('messages', function () {
//    return response()->json(Message::all());
//});


Route::middleware(['auth:sanctum', 'ttl:60'])->prefix('messages/')->group(function() {
    Route::get('search', [MessageController::class, 'search']);
    Route::delete('del-msg-img/{message_id}', [MessageController::class, 'delMsgImg']);
    Route::post('send-message/{username}', [MessageController::class, 'store']);
    Route::post('replay/{message_id}', [MessageController::class, 'replay']);
    Route::apiResource('', MessageController::class)->except(['store', 'show']);
});





