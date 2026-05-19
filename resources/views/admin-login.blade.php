<h1>Admin Login</h1>

<form method="POST" action="/admin-login">
    @csrf

    <p>
        <label>Email</label><br>
        <input type="email" name="email" required>
    </p>

    <p>
        <label>Password</label><br>
        <input type="password" name="password" required>
    </p>

    <button type="submit">Login</button>
</form>