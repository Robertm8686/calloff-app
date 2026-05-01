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

    $employee = DB::table('employees')
        ->where('phone', $from)
        ->first();

    $name = $employee ? $employee->name : 'Unknown Employee';
    $clientEmail = $employee && $employee->client_email 
        ? $employee->client_email 
        : 'kenji26m@gmail.com';

    Mail::raw("Employee called off.\n\nName: $name\nPhone: $from\nMessage: $message", function ($mail) use ($clientEmail) {
        $mail->to($clientEmail)
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
Route::get('/employees/create', function () {
    return view('employees-create');
});

Route::post('/employees', function (Request $request) {
    DB::table('employees')->insert([
        'name' => $request->input('name'),
        'phone' => $request->input('phone'),
        'client_name' => $request->input('client_name'),
        'client_email' => $request->input('client_email'),
        'active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect('/messages');
});