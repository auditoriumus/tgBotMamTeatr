<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {
    Route::post('/', [\App\Http\Controllers\api\v1\BotController::class, 'handle']);
    Route::apiResource('events', \App\Http\Controllers\api\v1\EventController::class)
        ->only(['store']);
});


