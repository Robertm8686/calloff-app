<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return 'App is working';
});

Route::post('/sms', function () {
    $message = request('Body');
    $from = request('From');

    Log::info('SMS received', [
        'from' => $from,
        'message' => $message
    ]);

    return response('OK');
});