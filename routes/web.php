<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'App is working';
});

Route::get('/public', function () {
    return 'App is working';
});

Route::post('/calloff', function () {
    $message = request('Body');
    $from = request('From');

    \Log::info('Call-off message received', [
        'from' => $from,
        'message' => $message
    ]);

    return response('OK');
});

Route::fallback(function () {
    return 'App is working';
});