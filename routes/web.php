use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/sms', function (Request $request) {

    $message = $request->input('Body');
    $from = $request->input('From');

    \Log::info('Call off message received', [
        'from' => $from,
        'message' => $message
    ]);

    return response('<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Message>Received your message</Message>
</Response>', 200)
    ->header('Content-Type', 'text/xml');
});