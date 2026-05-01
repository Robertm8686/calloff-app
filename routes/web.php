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

    // 🚨 SEND EMAIL IF CALLOFF
    if ($status === 'CALLOFF') {
        Mail::raw("Call-off detected\n\nFrom: $from\nMessage: $message", function ($mail) {
            $mail->to('kenji26m@gmail.com')
                 ->subject('🚨 Employee Call-Off Alert');
        });
    }

    return response('', 200);
});