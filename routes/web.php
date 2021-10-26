<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    app(\App\Http\Services\NotificationsService\NotificationsService::class)->__invoke();
});
