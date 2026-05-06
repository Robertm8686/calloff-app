<!DOCTYPE html>
<html>
<head>
    <title><?= ucfirst($client) ?> Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        a.button {
            display: inline-block;
            padding: 10px 14px;
            background: #6b7280;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        .badge {
            background:#dc2626;
            color:white;
            padding:4px 8px;
            border-radius:6px;
            font-weight:bold;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="topbar">
        <h1><?= ucfirst($client) ?> Dashboard</h1>
        <a class="button" href="/logout">Logout</a>
    </div>

    <div class="card">
        <h2>Call-Off Messages</h2>

        <table>
            <tr>
                <th>Employee</th>
                <th>Message</th>
                <th>Status</th>
                <th>Time</th>
            </tr>

            <?php foreach ($messages as $msg): ?>
            <tr class="<?= $msg->status === 'CALLOFF' ? 'calloff' : '' ?>">
                <td><?= $msg->employee_name ?? 'Unknown' ?></td>
                <td><?= $msg->body ?></td>
                <td>
                    <?php if ($msg->status === 'CALLOFF'): ?>
                        <span class="badge">CALLOFF</span>
                    <?php else: ?>
                        <?= $msg->status ?>
                    <?php endif; ?>
                </td>
                <td><?= date('m/d/Y g:i A', strtotime($msg->created_at)) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>
</body>
</html>