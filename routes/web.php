<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

Route::post('/sms', function (Request $request) {
    $message = strtolower($request->input('Body'));
    $from = $request->input('From');

    $status = str_contains($message, 'call off') ? 'CALLOFF' : 'OTHER';

    DB::table('messages')->insert([
        'from' => $from,
        'body' => $message,
        'status' => $status,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    if ($status === 'CALLOFF') {
        Mail::raw("Employee called off.\n\nFrom: $from\nMessage: $message", function ($mail) {
            $mail->to('kenji26m@gmail.com')
                ->subject('Call Off Alert');
        });
    }

    return response('', 200);
});

Route::get('/messages', function () {
    $messages = DB::table('messages')->get();
    return view('messages', ['messages' => $messages]);
});

Route::get('/test-email', function () {
    Mail::raw('This is a test email from the Calloff App.', function ($message) {
        $message->to('kenji26m@gmail.com')
            ->subject('Calloff App Test Email');
    });

    return 'Email sent';
});