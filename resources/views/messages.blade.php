<h1>Calloff Messages</h1>

<h2>Total Call Offs Today: <?= $todayCalloffs ?></h2>

<p>
    <a href="/messages">All Messages</a> |
    <a href="/messages?calloff=1">Call Off Only</a>
</p>

<h3>Call Offs by Client</h3>

<ul>
<?php foreach ($clientSummary as $client): ?>
    <li>
        <?= $client->client_name ?? 'Unknown' ?>: <?= $client->total ?>
    </li>
<?php endforeach; ?>
</ul>

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
<tr style="<?= $msg->status === 'CALLOFF' ? 'background-color: #ffcccc;' : '' ?>">
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