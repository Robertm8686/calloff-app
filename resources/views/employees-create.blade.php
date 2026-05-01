<h1>Add Employee</h1>

<form method="POST" action="/employees">
    @csrf

    <p>
        <label>Employee Name</label><br>
        <input type="text" name="name" required>
    </p>

    <p>
        <label>Phone Number</label><br>
        <input type="text" name="phone" placeholder="+19095410778" required>
    </p>

    <p>
        <label>Client / Worksite Name</label><br>
        <input type="text" name="client_name">
    </p>

    <p>
        <label>Client Email</label><br>
        <input type="email" name="client_email">
    </p>

    <button type="submit">Save Employee</button>
</form>

<p>
    <a href="/messages">Back to Messages</a>
</p>