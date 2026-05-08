<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    if ($status === 'CALLOFF' && $alreadyCalledOffToday) {
        return response('Duplicate call off ignored', 200);
    }

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

        $clientName = $employee
            ? $employee->client_name
            : 'N/A';

        $clientEmail = $employee && $employee->client_email
            ? $employee->client_email
            : 'kenji26m@gmail.com';

        Mail::raw(
            "Employee called off.\n\nName: $name\nClient: $clientName\nPhone: $from\nMessage: $message",
            function ($mail) use ($clientEmail) {
                $mail->to($clientEmail)
                    ->subject('Call Off Alert');
            }
        );
    }

    return response(
        '<Response><Message>Your call-off has been received.</Message></Response>',
        200
    )->header('Content-Type', 'text/xml');
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
            'client_name' => $request->client_name,
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

Route::post('/clients', function (Request $request) {
    DB::table('clients')->insert([
        'name' => strtolower($request->name),
        'email' => $request->email,
        'password' => $request->password,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect('/clients');
});