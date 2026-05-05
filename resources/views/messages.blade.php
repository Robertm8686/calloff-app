<h1>Calloff Messages</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>From</th>
        <th>Employee</th>
        <th>Client</th>
        <th>Message</th>
        <th>Status</th>
        <th>Received At</th>
    </tr>

<?php foreach ($messages as $msg): ?>
<tr>
    <td><?= $msg->id ?></td>
    <td><?= $msg->from ?></td>
    <td><?= $msg->employee_name ?? 'Unknown' ?></td>
    <td><?= $msg->client_name ?? 'N/A' ?></td>
    <td><?= $msg->body ?></td>
    <td><?= $msg->status ?? 'N/A' ?></td>
    <td><?= $msg->created_at ?></td>
</tr>
<?php endforeach; ?>

</table>