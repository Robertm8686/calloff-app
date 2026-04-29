<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| SMS Webhook (Twilio)
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Dashboard (View Messages)
|--------------------------------------------------------------------------
*/

Route::get('/messages', function () {
    $messages = DB::table('messages')
        ->orderByDesc('created_at')
        ->get();

    $html = '<h1>Calloff Messages</h1>';
    $html .= '<table border="1" cellpadding="10">';
    $html .= '<tr><th>ID</th><th>From</th><th>Message</th><th>Status</th><th>Received At</th></tr>';

    foreach ($messages as $message) {
        $html .= '<tr>';
        $html .= '<td>'.$message->id.'</td>';
        $html .= '<td>'.$message->from.'</td>';
        $html .= '<td>'.$message->body.'</td>';
        $html .= '<td>'.$message->status.'</td>';
        $html .= '<td>'.$message->created_at.'</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    return $html;
});

/*
|--------------------------------------------------------------------------
| Root Test
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return 'App is running';
});