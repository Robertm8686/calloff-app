<h1>Clients</h1>

<p>
    <a href="/clients/create">Add New Client</a>
</p>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Dashboard</th>
<th>Action</th>
    </tr>

@foreach($clients as $client)
<tr>
    <td>{{ $client->id }}</td>
    <td>{{ $client->name }}</td>
    <td>{{ $client->email }}</td>
    <td>
       <td>
    <a href="/client/{{ $client->name }}">View Dashboard</a>
</td>

<td>
    <a href="/clients/delete/{{ $client->id }}"
       onclick="return confirm('Delete this client?')">
       Delete
    </a>
</td>
    </td>
</tr>
@endforeach
</table>

<p>
    <a href="/messages">Back to Dashboard</a>
</p>