<h1>Employees</h1>

<a href="/employees/create">Add New Employee</a>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Client</th>
        <th>Email</th>
    </tr>

    @foreach ($employees as $emp)
    <tr>
        <td>{{ $emp->id }}</td>
        <td>{{ $emp->name }}</td>
        <td>{{ $emp->phone }}</td>
        <td>{{ $emp->client_name }}</td>
        <td>{{ $emp->client_email }}</td>
    </tr>
    @endforeach

</table>

<p>
    <a href="/messages">Back to Messages</a>
</p>