<h1>Add Client</h1>

<form method="POST" action="/clients">
    @csrf

    <p>
        <label>Client Name</label><br>
        <input type="text" name="name" required>
    </p>

    <p>
        <label>Client Email</label><br>
        <input type="email" name="email" required>
    </p>

    <p>
        <label>Password</label><br>
        <input type="text" name="password" value="1234" required>
    </p>
<p>
    <label>Notification Email</label><br>
    <input type="email" name="notification_email">
</p>

<p>
    <label>Notification Phone</label><br>
    <input type="text" name="notification_phone" placeholder="+19095410778">
</p>

<p>
    <label>
        <input type="checkbox" name="notify_email" checked>
        Send Email Alerts
    </label>
</p>

<p>
    <label>
        <input type="checkbox" name="notify_sms">
        Send SMS Alerts
    </label>
</p>
    <button type="submit">Save Client</button>
</form>

<p>
    <a href="/clients">Back to Clients</a>
</p>