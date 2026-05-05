<h1>Client Login</h1>

<form method="POST" action="/login">
    <input type="hidden" name="_token" value="<?= csrf_token() ?>">

    <input type="text" name="email" placeholder="Email"><br><br>
    <input type="password" name="password" placeholder="Password"><br><br>

    <button type="submit">Login</button>
</form>