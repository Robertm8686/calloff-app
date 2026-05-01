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

    // 🔥 ADD THIS
    if ($status === 'CALLOFF') {
        Mail::raw('Employee called off: ' . $message, function ($mail) {
            $mail->to('kenji26m@gmail.com')
                 ->subject('Call Off Alert');
        });
    }

    return response('', 200);
});