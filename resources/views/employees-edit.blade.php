<h1>Edit Employee</h1>

<form method="POST" action="/employees/{{ $employee->id }}/update">
    @csrf

    <p>
        <label>Name</label><br>
        <input type="text" name="name" value="{{ $employee->name }}" required>
    </p>

    <p>
        <label>Phone</label><br>
        <input type="text" name="phone" value="{{ $employee->phone }}" required>
    </p>

    <p>
        <label>Client</label><br>
        <input type="text" name="client_name" value="{{ $employee->client_name }}" required>
    </p>

    <p>
        <label>Email</label><br>
        <input type="email" name="client_email" value="{{ $employee->client_email }}">
    </p>

    <button type="submit">Update Employee</button>
</form>

<p>
    <a href="/employees">Back to Employees</a>
</p>