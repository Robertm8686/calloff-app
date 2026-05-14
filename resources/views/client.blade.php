<!DOCTYPE html>
<html>
<head>
    <title><?= ucfirst($client) ?> Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            padding: 30px;
            margin: 0;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        h1 {
            margin-top: 0;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .stat-box {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #dc2626;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #111827;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .badge {
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 12px;
        }

        .red {
            background: #dc2626;
        }

        .orange {
            background: #f59e0b;
        }

        .green {
            background: #16a34a;
        }

        .gray {
            background: #6b7280;
        }

        a.button {
            background: #2563eb;
            color: white;
            padding: 10px 14px;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="topbar">
        <h1><?= ucfirst($client) ?> Dashboard</h1>

        <a class="button" href="/logout">
            Logout
        </a>
    </div>

    <?php
        $todayCount = 0;
        $acknowledgedCount = 0;
        $resolvedCount = 0;

        foreach ($messages as $m) {

            if ($m->status === 'CALLOFF') {
                $todayCount++;
            }

            if ($m->acknowledged) {
                $acknowledgedCount++;
            }

            if ($m->resolved) {
                $resolvedCount++;
            }
        }
    ?>

    <div class="stats">

        <div class="stat-box">
            <div>Total Call Offs</div>
            <div class="stat-number">
                <?= $todayCount ?>
            </div>
        </div>

        <div class="stat-box">
            <div>Acknowledged</div>
            <div class="stat-number">
                <?= $acknowledgedCount ?>
            </div>
        </div>

        <div class="stat-box">
            <div>Resolved</div>
            <div class="stat-number">
                <?= $resolvedCount ?>
            </div>
        </div>

    </div>

    <div class="card">

        <table>

            <tr>
                <th>Employee</th>
                <th>Message</th>
                <th>Status</th>
                <th>Received</th>
                <th>Acknowledged</th>
                <th>Resolved</th>
            </tr>

            <?php foreach ($messages as $msg): ?>

            <tr>

                <td>
                    <?= $msg->employee_name ?? 'Unknown' ?>
                </td>

                <td>
                    <?= $msg->body ?>
                </td>

                <td>

                    <?php if ($msg->status === 'CALLOFF'): ?>

                        <span class="badge red">
                            CALLOFF
                        </span>

                    <?php elseif ($msg->status === 'DUPLICATE'): ?>

                        <span class="badge orange">
                            DUPLICATE
                        </span>

                    <?php else: ?>

                        <span class="badge gray">
                            <?= $msg->status ?>
                        </span>

                    <?php endif; ?>

                </td>

                <td>
                    <?= date('m/d/Y g:i A', strtotime($msg->created_at)) ?>
                </td>

                <td>

                    <?php if ($msg->acknowledged): ?>

                        <span class="badge green">
                            YES
                        </span>

                    <?php else: ?>

                        <span class="badge gray">
                            NO
                        </span>

                    <?php endif; ?>

                </td>

                <td>

                    <?php if ($msg->resolved): ?>

                        <span class="badge green">
                            YES
                        </span>

                    <?php else: ?>

                        <span class="badge gray">
                            NO
                        </span>

                    <?php endif; ?>

                </td>

            </tr>

            <?php endforeach; ?>

        </table>

    </div>

</div>

</body>
</html>