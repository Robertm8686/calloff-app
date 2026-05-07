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

    <button type="submit">Save Client</button>
</form>

<p>
    <a href="/clients">Back to Clients</a>
</p>