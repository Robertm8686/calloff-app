<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🔹 Receive SMS (Twilio webhook)
Route::post('/sms', function (Request $request) {

    $message = strtolower($request->input('Body'));
    $from = $request->input('From');

    // Detect call off
    $status = str_contains($message, 'call off') ? 'CALLOFF' : 'OTHER';

    DB::table('messages')->insert([
        'from' => $from,
        'body' => $message,
        'status' => $status,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response('', 200);
});


// 🔹 Dashboard page
Route::get('/messages', function () {
    $messages = DB::table('messages')->get();
    return view('messages', ['messages' => $messages]);
});