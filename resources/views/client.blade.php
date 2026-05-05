<p>
    <a href="/logout">Logout</a>
</p>
<h1><?= ucfirst($client) ?> Dashboard</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>Employee</th>
        <th>Message</th>
        <th>Status</th>
        <th>Time</th>
    </tr>

<?php foreach ($messages as $msg): ?>
<tr style="<?= $msg->status === 'CALLOFF' ? 'background:#fee2e2;' : '' ?>">
    <td><?= $msg->employee_name ?? 'Unknown' ?></td>
    <td><?= $msg->body ?></td>
    <td><?= $msg->status ?></td>
    <td><?= date('m/d/Y g:i A', strtotime($msg->created_at)) ?></td>
</tr>
<?php endforeach; ?>

</table>