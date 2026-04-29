use Illuminate\Support\Facades\DB;

Route::post('/sms', function (Request $request) {
    $message = $request->input('Body');
    $from = $request->input('From');

    // Save to database
    DB::table('messages')->insert([
        'from' => $from,
        'body' => $message,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response('', 200);
});