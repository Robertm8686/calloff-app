<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return 'App is working';
});

Route::post('/sms', function (Request $request) {
    $message = $request->input('Body');

    return response(
        '<Response><Message>Got your message: '.$message.'</Message></Response>',
        200
    )->header('Content-Type', 'text/xml');
});