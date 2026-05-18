<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

Route::post('/sms', function (Request $request) {

    $message = strtolower($request->input('Body'));
    $from = $request->input('From');

    $calloffPhrases = [
        'call off',
        'call of',
        'called off',
        'calling off',
        'sick',
        'not coming',
        'not coming in',
        'cant make it',
        "can't make it",
        'cannot make it',
        'wont make it',
        "won't make it",
        'cant come in',
        "can't come in",
        'cannot come in',
        'not going in',
        'miss work',
        'missing work',
        'out today',
        'car broke down',
        'family emergency',
        'emergency',
        'no ride',
        'running a fever',
        'throwing up',
        'injured',
        'hospital',
        'no puedo ir',
        'no puedo llegar',
        'no voy a ir',
        'no ire',
        'no iré',
        'no puedo trabajar',
        'me siento enfermo',
        'me siento enferma',
        'estoy enfermo',
        'estoy enferma',
        'estoy malo',
        'estoy mala',
        'me enferme',
        'me enfermé',
        'tengo fiebre',
        'vomitando',
        'tengo emergencia',
        'emergencia familiar',
        'se me descompuso el carro',
        'no tengo transporte',
        'no tengo ride',
        'no puedo presentarme',
        'no puedo asistir',
    ];

    $status = 'OTHER';

    foreach ($calloffPhrases as $phrase) {
        if (str_contains($message, $phrase)) {
            $status = 'CALLOFF';
            break;
        }
    }

    $alreadyCalledOffToday = DB::table('messages')
        ->where('from', $from)
        ->where('status', 'CALLOFF')
        ->whereDate('created_at', today())
        ->exists();

    $finalStatus = $status;

    if ($status === 'CALLOFF' && $alreadyCalledOffToday) {
        $finalStatus = 'DUPLICATE';
    }

    $messageId = DB::table('messages')->insertGetId([
        'from' => $from,
        'body' => $message,
        'status' => $finalStatus,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $employee = DB::table('employees')
        ->where('phone', $from)
        ->first();

    $name = $employee ? $employee->name : 'Unknown Employee';

    $clientName = $employee
        ? $employee->client_name
        : 'N/A';

    $client = DB::table('clients')
        ->where('name', strtolower($clientName))
        ->first();

    $notificationSent = false;

    if ($finalStatus === 'CALLOFF') {

        $emailBody = "Employee called off.\n\nName: $name\nClient: $clientName\nPhone: $from\nMessage: $message";

        if ($client && $client->notify_email && $client->notification_email) {
            Mail::raw($emailBody, function ($mail) use ($client) {
                $mail->to($client->notification_email)
                    ->subject('Call Off Alert');
            });

            $notificationSent = true;
        }
    }

    if ($finalStatus === 'CALLOFF' || $finalStatus === 'DUPLICATE') {
        try {
            Http::withHeaders([
                'Content-Type' => 'application/json',
                'api-key' => env('BASE44_API_KEY'),
            ])->post(
                'https://api.base44.com/api/apps/' . env('BASE44_APP_ID') . '/entities/CallOff',
                [
                    'caller_phone' => $from,
                    'source' => 'sms',
                    'detected_status' => $finalStatus,
                    'employee_name' => $name,
                    'client_name' => $clientName,
                    'call_off_date' => now()->format('Y-m-d'),
                    'reason' => 'other',
                    'method' => 'text',
                    'raw_message' => $message,
                    'notes' => $message,
                    'notification_sent' => $notificationSent,
                    'notification_email' => $client->notification_email ?? null,
                    'duplicate' => $finalStatus === 'DUPLICATE',
                    'render_message_id' => (string) $messageId,
                ]
            );
        } catch (\Exception $e) {
            // Ignore Base44 sync failure for now
        }
    }

    return response(
        '<Response><Message>Your call-off has been received.</Message></Response>',
        200
    )->header('Content-Type', 'text/xml');
});
Route::get('/messages/{id}/resolve', function ($id) {

    DB::table('messages')
        ->where('id', $id)
        ->update([
            'resolved' => true,
            'resolved_at' => now(),
            'updated_at' => now(),
        ]);

    return redirect('/messages');
});
Route::get('/messages/{id}/acknowledge', function ($id) {

    DB::table('messages')
        ->where('id', $id)
        ->update([
            'acknowledged' => true,
            'acknowledged_at' => now(),
            'updated_at' => now(),
        ]);

    return redirect('/messages');
});
Route::get('/messages', function (Request $request) {

    $query = DB::table('messages')
        ->leftJoin('employees', 'messages.from', '=', 'employees.phone')
        ->select(
            'messages.*',
            'employees.name as employee_name',
            'employees.client_name as client_name'
        );

    if ($request->input('calloff') == 1) {
        $query->where('messages.status', 'CALLOFF');
    }

    if ($request->input('search')) {

        $search = $request->input('search');

        $query->where(function ($q) use ($search) {
            $q->where('messages.from', 'like', "%$search%")
              ->orWhere('employees.name', 'like', "%$search%")
              ->orWhere('employees.client_name', 'like', "%$search%");
        });
    }

    $messages = $query
        ->orderByDesc('messages.created_at')
        ->get();

    $todayCalloffs = DB::table('messages')
        ->where('status', 'CALLOFF')
        ->whereDate('created_at', today())
        ->count();

    $clientSummary = DB::table('messages')
        ->leftJoin('employees', 'messages.from', '=', 'employees.phone')
        ->select('employees.client_name', DB::raw('count(*) as total'))
        ->where('messages.status', 'CALLOFF')
        ->whereDate('messages.created_at', today())
        ->groupBy('employees.client_name')
        ->get();

    return view('messages', [
        'messages' => $messages,
        'todayCalloffs' => $todayCalloffs,
        'clientSummary' => $clientSummary
    ]);
});

Route::get('/test-email', function () {

    Mail::raw('This is a test email from the Calloff App.', function ($message) {
        $message->to('kenji26m@gmail.com')
            ->subject('Calloff App Test Email');
    });

    return 'Email sent';
});

Route::get('/employees', function () {

    $employees = DB::table('employees')->get();

    return view('employees', [
        'employees' => $employees
    ]);
});

Route::get('/employees/create', function () {
    return view('employees-create');
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

    return redirect('/employees');
});

Route::get('/employees/{id}/edit', function ($id) {

    $employee = DB::table('employees')
        ->where('id', $id)
        ->first();

    return view('employees-edit', [
        'employee' => $employee
    ]);
});

Route::post('/employees/{id}/update', function (Request $request, $id) {

    DB::table('employees')
        ->where('id', $id)
        ->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'client_name' => strtolower($request->client_name),
            'client_email' => $request->client_email,
            'updated_at' => now(),
        ]);

    return redirect('/employees');
});

Route::get('/employees/delete/{id}', function ($id) {

    DB::table('employees')
        ->where('id', $id)
        ->delete();

    return redirect('/employees');
});

Route::get('/send-daily-summary', function () {

    $clients = DB::table('messages')
        ->leftJoin('employees', 'messages.from', '=', 'employees.phone')
        ->select(
            'employees.client_name',
            'employees.client_email',
            'employees.name',
            'messages.body',
            'messages.created_at'
        )
        ->where('messages.status', 'CALLOFF')
        ->whereDate('messages.created_at', today())
        ->get()
        ->groupBy('client_name');

    foreach ($clients as $clientName => $records) {

        $clientEmail = $records[0]->client_email ?? 'kenji26m@gmail.com';

        $body = "Daily Call-Off Summary\n\nClient: $clientName\n\n";

        foreach ($records as $r) {

            $name = $r->name ?? 'Unknown Employee';

            $body .= "- {$name} ({$r->created_at}): {$r->body}\n";
        }

        Mail::raw($body, function ($mail) use ($clientEmail, $clientName) {

            $mail->to($clientEmail)
                ->subject("Daily Call-Off Summary - $clientName");
        });
    }

    return "Summary emails sent";
});

Route::get('/client/{client}', function ($client) {

    if (session('client') !== $client) {
        return redirect('/login');
    }

    $messages = DB::table('messages')
        ->leftJoin('employees', 'messages.from', '=', 'employees.phone')
        ->select(
            'messages.*',
            'employees.name as employee_name',
            'employees.client_name as client_name'
        )
        ->where('employees.client_name', $client)
        ->orderByDesc('messages.created_at')
        ->get();

    return view('client', [
        'messages' => $messages,
        'client' => $client
    ]);
});

Route::get('/login', function () {

    return view('login');
});

Route::post('/login', function (Request $request) {

    $client = DB::table('clients')
        ->where('email', $request->email)
        ->first();

    if ($client && $request->password === $client->password) {

        session([
            'client' => $client->name
        ]);

        return redirect('/client/' . $client->name);
    }

    return 'Login failed';
});

Route::get('/logout', function () {

    session()->flush();

    return redirect('/login');
});
Route::get('/debug-clients', function () {
    return DB::table('clients')->get();
});
Route::get('/seed-client', function () {
    DB::table('clients')->updateOrInsert(
        ['email' => 'castle@gmail.com'],
        [
            'name' => 'castle',
            'password' => '1234',
            'created_at' => now(),
            'updated_at' => now(),
        ]
    );

    return 'Client added';
});
Route::get('/clients', function () {
    $clients = DB::table('clients')->get();

    return view('clients', [
        'clients' => $clients
    ]);
});

Route::get('/clients/create', function () {
    return view('clients-create');
});
Route::get('/clients/{id}/edit', function ($id) {

    $client = DB::table('clients')
        ->where('id', $id)
        ->first();

    return view('clients-edit', [
        'client' => $client
    ]);
});

Route::post('/clients/{id}/update', function (Request $request, $id) {

    DB::table('clients')
        ->where('id', $id)
        ->update([
            'name' => strtolower($request->name),
            'email' => $request->email,
            'password' => $request->password,
            'notification_email' => $request->notification_email,
            'notification_phone' => $request->notification_phone,
            'notify_email' => $request->has('notify_email'),
            'notify_sms' => $request->has('notify_sms'),
            'updated_at' => now(),
        ]);

    return redirect('/clients');
});
Route::post('/clients', function (Request $request) {

    DB::table('clients')->insert([
        'name' => strtolower($request->name),
        'email' => $request->email,
        'password' => $request->password,
        'notification_email' => $request->notification_email,
        'notification_phone' => $request->notification_phone,
        'notify_email' => $request->has('notify_email'),
        'notify_sms' => $request->has('notify_sms'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect('/clients');
});

Route::get('/clients/delete/{id}', function ($id) {

    DB::table('clients')
        ->where('id', $id)
        ->delete();

    return redirect('/clients');
});
Route::post('/voice', function () {

    return response('
<Response>

    <Say voice="alice">
        Please leave your call off message after the beep.
        Para español, deje su mensaje después del tono.
    </Say>

    <Record
        maxLength="60"
        playBeep="true"
        recordingStatusCallback="/voice-recording"
    />

</Response>
', 200)->header('Content-Type', 'text/xml');

});
Route::post('/voice-recording', function (Request $request) {

    $from = $request->From;
    $recordingUrl = $request->RecordingUrl;

    $employee = DB::table('employees')
        ->where('phone', $from)
        ->first();

    $name = $employee->name ?? 'Unknown';
    $clientName = $employee->client_name ?? 'Unknown';

    $messageId = DB::table('messages')->insertGetId([
        'from' => $from,
        'body' => 'Voice call received',
        'status' => 'CALLOFF',
        'recording_url' => $recordingUrl,
        'transcription_status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $transcriptionText = null;
    $transcriptionStatus = 'failed';

    try {
        $audioUrl = $recordingUrl . '.mp3';

        $audioResponse = Http::withBasicAuth(
            env('TWILIO_ACCOUNT_SID'),
            env('TWILIO_AUTH_TOKEN')
        )->get($audioUrl);

        if ($audioResponse->successful()) {

            $transcriptionResponse = Http::withToken(env('OPENAI_API_KEY'))
                ->attach(
                    'file',
                    $audioResponse->body(),
                    'recording.mp3'
                )
                ->post('https://api.openai.com/v1/audio/transcriptions', [
                    'model' => 'whisper-1',
                    'response_format' => 'json',
                ]);

            if ($transcriptionResponse->successful()) {
                $transcriptionText = $transcriptionResponse->json('text');
                $transcriptionStatus = 'complete';
            }
        }

    } catch (\Exception $e) {
        $transcriptionStatus = 'failed';
    }

$voiceStatus = 'OTHER';

if ($transcriptionText) {

    $transcriptionLower = strtolower($transcriptionText);

    $calloffPhrases = [
        'call off',
        'sick',
        'not coming',
        'cant make it',
        "can't make it",
        'cannot make it',
        'family emergency',
        'hospital',
        'no puedo ir',
        'no voy a ir',
        'estoy enfermo',
        'estoy enferma',
        'no puedo trabajar',
        'tengo fiebre',
        'emergencia familiar'
    ];

    foreach ($calloffPhrases as $phrase) {

        if (str_contains($transcriptionLower, $phrase)) {

            $voiceStatus = 'CALLOFF';
            break;
        }
    }
}

$alreadyCalledOffToday = DB::table('messages')
    ->where('from', $from)
    ->where('status', 'CALLOFF')
    ->whereDate('created_at', today())
    ->where('id', '!=', $messageId)
    ->exists();

if ($voiceStatus === 'CALLOFF' && $alreadyCalledOffToday) {
    $voiceStatus = 'DUPLICATE';
}

DB::table('messages')
    ->where('id', $messageId)
    ->update([
        'status' => $voiceStatus,
        'transcription' => $transcriptionText,
        'transcription_status' => $transcriptionStatus,
        'updated_at' => now(),
    ]);

if ($voiceStatus === 'CALLOFF') {

    $client = DB::table('clients')
        ->where('name', strtolower($clientName))
        ->first();

    $emailBody = "Voice Call Off Received\n\n"
        . "Employee: $name\n"
        . "Client: $clientName\n"
        . "Phone: $from\n\n"
        . "Transcription:\n"
        . ($transcriptionText ?? 'Transcription unavailable') . "\n\n"
        . "Recording:\n"
        . $recordingUrl;

    if ($client && $client->notify_email && $client->notification_email) {

        Mail::raw($emailBody, function ($mail) use ($client) {

            $mail->to($client->notification_email)
                ->subject('Voice Call Off Alert');

        });

    }
}

    return response('OK', 200);
});
Route::get('/run-migrations', function () {
    Artisan::call('migrate', ['--force' => true]);
    return nl2br(Artisan::output());
});