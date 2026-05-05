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

Route::get('/messages', function (Request $request) {

    $query = DB::table('messages')
        ->leftJoin('employees', 'messages.from', '=', 'employees.phone')
        ->select(
            'messages.*',
            'employees.name as employee_name',
            'employees.client_name as client_name'
        );

    // filter if ?calloff=1
    if ($request->input('calloff') == 1) {
        $query->where('messages.status', 'CALLOFF');
    }

    $messages = $query->get();

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
Route::post('/employees', function (Request $request) {

    DB::table('employees')->insert([
        'name' => $request->name,
        'phone' => $request->phone,
        'client_name' => $request->client_name,
        'client_email' => $request->client_email,
        'active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect('/employees/create');
});
Route::get('/employees', function () {
    $employees = DB::table('employees')->get();
    return view('employees', ['employees' => $employees]);
});
Route::get('/employees/{id}/edit', function ($id) {
    $employee = DB::table('employees')->where('id', $id)->first();
    return view('employees-edit', ['employee' => $employee]);
});

Route::post('/employees/{id}/update', function (Request $request, $id) {
    DB::table('employees')->where('id', $id)->update([
        'name' => $request->name,
        'phone' => $request->phone,
        'client_name' => $request->client_name,
        'client_email' => $request->client_email,
        'updated_at' => now(),
    ]);

    return redirect('/employees');
});
Route::post('/employees/{id}/delete', function ($id) {
    DB::table('employees')->where('id', $id)->delete();

    return redirect('/employees');
});
Route::get('/employees/delete/{id}', function ($id) {
    DB::table('employees')->where('id', $id)->delete();
    return redirect('/employees');
});
Route::get('/employees/delete/{id}', function ($id) {
    DB::table('employees')->where('id', $id)->delete();
    return redirect('/employees');
});