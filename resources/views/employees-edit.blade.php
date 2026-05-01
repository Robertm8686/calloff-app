<h1>Edit Employee</h1>

<form method="POST" action="/employees/{{ $employee->id }}/update">
    @csrf

    <p>
        <label>Employee Name</label><br>
        <input type="text" name="name" value="{{ $employee->name }}" required>
    </p>

    <p>
        <label>Phone Number</label><br>
        <input type="text" name="phone" value="{{ $employee->phone }}" required>
    </p>

    <p>
        <label>Client / Worksite Name</label><br>
        <input type="text" name="client_name" value="{{ $employee->client_name }}">
    </p>

    <p>
        <label>Client Email</label><br>
        <input type="email" name="client_email" value="{{ $employee->client_email }}">
    </p>

    <button type="submit">Update Employee</button>
</form>

<p>
    <a href="/employees">Back to Employees</a>
</p>