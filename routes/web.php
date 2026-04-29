<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return 'App is working';
});

Route::post('/sms', function (Request $request) {
    $message = $request->input('Body');

    // temporarily disable reply
    return response('', 200);
});