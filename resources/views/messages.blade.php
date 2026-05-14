<!DOCTYPE html>
<html>
<head>
    <title>Calloff Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        h1 {
            margin-top: 0;
        }

        .stats {
            display: flex;
            gap: 20px;
        }

        .stat-box {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            flex: 1;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #c0392b;
        }

        a.button {
            display: inline-block;
            padding: 10px 14px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-right: 8px;
        }

        a.button.secondary {
            background: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th {
            background: #111827;
            color: white;
            text-align: left;
            padding: 12px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr.calloff {
            background: #fee2e2;
        }

        .status {
            font-weight: bold;
            color: #b91c1c;
        }
    </style>
</head>
<body>
<div class="container">

    <h1>Calloff Dashboard</h1>

    <div class="stats">
        <div class="stat-box">
            <div>Total Call Offs Today</div>
            <div class="stat-number"><?= $todayCalloffs ?></div>
        </div>

        <div class="stat-box">
            <div>Clients with Call Offs</div>
            <div class="stat-number"><?= count($clientSummary) ?></div>
        </div>
    </div>

    <div class="card">
        <a class="button" href="/messages">All Messages</a>
<div class="card">
    <form method="GET" action="/messages">
        <input 
            type="text" 
            name="search" 
            placeholder="Search employee, phone, or client..." 
            style="padding:10px;width:300px;border-radius:6px;border:1px solid #ccc;"
            value="<?= $_GET['search'] ?? '' ?>"
        >

        <button type="submit" class="button">Search</button>
    </form>
</div>
        <a class="button secondary" href="/messages?calloff=1">Call Off Only</a>
        <a class="button secondary" href="/employees">Employees</a><a class="button secondary" href="/clients">Clients</a>
        <a class="button secondary" href="/send-daily-summary">Send Daily Summary</a>
    </div>
<div class="card">
    <form method="GET" action="/messages">
        <input 
            type="text" 
            name="search" 
            placeholder="Search employee, phone, or client..." 
            style="padding:10px;width:300px;border-radius:6px;border:1px solid #ccc;"
            value="<?= $_GET['search'] ?? '' ?>"
        >

        <button type="submit" class="button">Search</button>
    </form>
</div>
    <div class="card">
        <h2>Call Offs by Client</h2>

<?php if (count($clientSummary) === 0): ?>
    <p>No call offs today</p>
<?php else: ?>
    <ul>
    <?php foreach ($clientSummary as $client): ?>
        <li>
            <?= $client->client_name ?? 'Unknown' ?>: <?= $client->total ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
    </div>
<div class="card">
    <h2>Today's Call-Offs</h2>

    <?php if (count($clientSummary) === 0): ?>
        <p>No call offs today</p>
    <?php else: ?>
        <?php foreach ($clientSummary as $client): ?>
            <h3><?= $client->client_name ?? 'Unknown' ?></h3>

            <ul>
            <?php foreach ($messages as $msg): ?>
                <?php if ($msg->status === 'CALLOFF' && $msg->client_name == $client->client_name): ?>
                    <li>
                        <?= $msg->employee_name ?? 'Unknown' ?>
                        (<?= date('m/d/Y g:i A', strtotime($msg->created_at)) ?>)
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
    <div class="card">
        <h2>Messages</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>From</th>
                <th>Employee</th>
                <th>Client</th>
                <th>Message</th>
                <th>Status</th>
                <th>Received At</th> !!!!!!
<th>Received At</th>
<th>Acknowledged</th>
<th>Resolved</th>
<th>Action</th>
</tr>

<?php foreach ($messages as $msg): ?>
<tr style="<?= $msg->status === 'CALLOFF' ? 'background:#fee2e2;border-left:5px solid #dc2626;' : '' ?>">
    <td><?= $msg->id ?></td>
    <td><?= $msg->from ?></td>
    <td><?= $msg->employee_name ?? 'Unknown' ?></td>
    <td><?= $msg->client_name ?? 'N/A' ?></td>
    <td><?= $msg->body ?></td>

<td>

<?php if ($msg->status === 'CALLOFF'): ?>

    <span style="
        background:#dc2626;
        color:white;
        padding:4px 8px;
        border-radius:6px;
        font-weight:bold;
    ">
        CALLOFF
    </span>

<?php elseif ($msg->status === 'DUPLICATE'): ?>

    <span style="
        background:#f59e0b;
        color:white;
        padding:4px 8px;
        border-radius:6px;
        font-weight:bold;
    ">
        DUPLICATE
    </span>

<?php else: ?>

    <span style="
        background:#e5e7eb;
        color:#374151;
        padding:4px 8px;
        border-radius:6px;
    ">
        <?= $msg->status ?? 'N/A' ?>
    </span>

<?php endif; ?>

</td>

<td><?= date('m/d/Y g:i A', strtotime($msg->created_at)) ?></td>

<td>
    <?php if ($msg->acknowledged): ?>
        Yes<br>
        <?= date('m/d/Y g:i A', strtotime($msg->acknowledged_at)) ?>
    <?php else: ?>
        No
    <?php endif; ?>
</td>

<td>
    <?php if ($msg->resolved): ?>
        Yes<br>
        <?= date('m/d/Y g:i A', strtotime($msg->resolved_at)) ?>
    <?php else: ?>
        No
    <?php endif; ?>
</td>

<td>

    <?php if (!$msg->acknowledged && $msg->status === 'CALLOFF'): ?>

        <a href="/messages/<?= $msg->id ?>/acknowledge">
            Acknowledge
        </a>

    <?php elseif ($msg->acknowledged && !$msg->resolved && $msg->status === 'CALLOFF'): ?>

        <a href="/messages/<?= $msg->id ?>/resolve">
            Resolve
        </a>

    <?php else: ?>
        —
    <?php endif; ?>

</td>

</tr>
<?php endforeach; ?>
        <?php foreach ($messages as $msg): ?>
            <tr style="<?= $msg->status === 'CALLOFF' ? 'background:#fee2e2;border-left:5px solid #dc2626;' : '' ?>">
                <td><?= $msg->id ?></td>
                <td><?= $msg->from ?></td>
                <td><?= $msg->employee_name ?? 'Unknown' ?></td>
                <td><?= $msg->client_name ?? 'N/A' ?></td>
                <td><?= $msg->body ?></td>
<td>

<?php if ($msg->status === 'CALLOFF'): ?>

    <span style="
        background:#dc2626;
        color:white;
        padding:4px 8px;
        border-radius:6px;
        font-weight:bold;
    ">
        CALLOFF
    </span>

<?php elseif ($msg->status === 'DUPLICATE'): ?>

    <span style="
        background:#f59e0b;
        color:white;
        padding:4px 8px;
        border-radius:6px;
        font-weight:bold;
    ">
        DUPLICATE
    </span>

<?php else: ?>

    <span style="
        background:#e5e7eb;
        color:#374151;
        padding:4px 8px;
        border-radius:6px;
    ">
        <?= $msg->status ?? 'N/A' ?>
    </span>

<?php endif; ?>

</td>
                <td><?= date('m/d/Y g:i A', strtotime($msg->created_at)) ?></td>
<td>
    <?php if ($msg->acknowledged): ?>
        Yes<br>
        <?= date('m/d/Y g:i A', strtotime($msg->acknowledged_at)) ?>
    <?php else: ?>
        No
    <?php endif; ?>
</td>

<td>
    <?php if (!$msg->acknowledged && $msg->status === 'CALLOFF'): ?>
        <a href="/messages/<?= $msg->id ?>/acknowledge">Acknowledge</a>
    <?php else: ?>
        —
    <?php endif; ?>
</td>
            </tr>
        <?php endforeach; ?>

        </table>
    </div>

</div>
</body>
</html>