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
    $messages = DB::table('messages')
        ->orderByDesc('created_at')
        ->get();

    $html = '<h1>Calloff Messages</h1>';
    $html .= '<table border="1" cellpadding="10">';
    $html .= '<tr><th>ID</th><th>From</th><th>Message</th><th>Received At</th></tr>';

    foreach ($messages as $message) {
        $html .= '<tr>';
        $html .= '<td>'.$message->id.'</td>';
        $html .= '<td>'.$message->from.'</td>';
        $html .= '<td>'.$message->body.'</td>';
        $html .= '<td>'.$message->created_at.'</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    return $html;
});