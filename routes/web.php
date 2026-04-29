<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return 'App is working';
});

Route::post('/sms', function (Request $request) {
    DB::table('messages')->insert([
        'from' => $request->input('From'),
        'body' => $request->input('Body'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response('', 200);
});

Route::get('/messages', function () {
    return DB::table('messages')->get();
});