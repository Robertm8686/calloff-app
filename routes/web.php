<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return 'App is working';
});

Route::post('/sms', function (Request $request) {
    Log::info('Call off message received', [
        'from' => $request->input('From'),
        'message' => $request->input('Body'),
    ]);

    return response('<?xml version="1.0" encoding="UTF-8"?><Response><Message>Received your message</Message></Response>', 200)
        ->header('Content-Type', 'text/xml');
});