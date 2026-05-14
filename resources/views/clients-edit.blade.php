<h1>Edit Client</h1>

<form method="POST" action="/clients/{{ $client->id }}/update">
    @csrf

    <p>
        <label>Client Name</label><br>
        <input type="text" name="name" value="{{ $client->name }}" required>
    </p>

    <p>
        <label>Client Login Email</label><br>
        <input type="email" name="email" value="{{ $client->email }}" required>
    </p>

    <p>
        <label>Password</label><br>
        <input type="text" name="password" value="{{ $client->password }}" required>
    </p>

    <p>
        <label>Notification Email</label><br>
        <input type="email" name="notification_email" value="{{ $client->notification_email }}">
    </p>

    <p>
        <label>Notification Phone</label><br>
        <input type="text" name="notification_phone" value="{{ $client->notification_phone }}" placeholder="+19095410778">
    </p>

    <p>
        <label>
            <input type="checkbox" name="notify_email" {{ $client->notify_email ? 'checked' : '' }}>
            Send Email Alerts
        </label>
    </p>

    <p>
        <label>
            <input type="checkbox" name="notify_sms" {{ $client->notify_sms ? 'checked' : '' }}>
            Send SMS Alerts
        </label>
    </p>

    <button type="submit">Update Client</button>
</form>

<p>
    <a href="/clients">Back to Clients</a>
</p>