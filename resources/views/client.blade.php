<!DOCTYPE html>
<html>
<head>
    <title><?= ucfirst($client) ?> Portal - CallOffApp</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #111827;
        }

        .layout {
            min-height: 100vh;
            padding: 34px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        h1 {
            margin: 0;
            font-size: 32px;
        }

        .subtitle {
            color: #64748b;
            margin-top: 8px;
        }

        .button {
            display: inline-block;
            background: #111827;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: bold;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 26px;
        }

        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 2px 8px rgba(15,23,42,0.08);
        }

        .stat-label {
            color: #64748b;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            margin-top: 10px;
        }

        .panel {
            background: white;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15,23,42,0.08);
            overflow: hidden;
        }

        .panel-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
        }

        .panel-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
        }

        th {
            background: #111827;
            color: white;
            padding: 14px;
            text-align: left;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr.calloff {
            background: #fee2e2;
            border-left: 5px solid #dc2626;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 12px;
        }

        .badge-red {
            background: #dc2626;
            color: white;
        }

        .badge-orange {
            background: #f59e0b;
            color: white;
        }

        .badge-green {
            background: #16a34a;
            color: white;
        }

        .badge-gray {
            background: #e5e7eb;
            color: #374151;
        }

        .footer-note {
            margin-top: 20px;
            color: #64748b;
            font-size: 13px;
            text-align: center;
        }

        @media (max-width: 900px) {
            .layout {
                padding: 20px;
            }

            .topbar {
                display: block;
            }

            .topbar .button {
                margin-top: 15px;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="layout">
<div class="container">

    <div class="topbar">
        <div>
            <h1><?= ucfirst($client) ?> Portal</h1>
            <div class="subtitle">
                Real-time staffing call-off activity
            </div>
        </div>

        <a class="button" href="/logout">Logout</a>
    </div>

    <?php
        $calloffCount = 0;
        $duplicateCount = 0;
        $resolvedCount = 0;

        foreach ($messages as $m) {
            if ($m->status === 'CALLOFF') {
                $calloffCount++;
            }

            if ($m->status === 'DUPLICATE') {
                $duplicateCount++;
            }

            if ($m->resolved) {
                $resolvedCount++;
            }
        }
    ?>

    <div class="cards">

        <div class="stat-card">
            <div class="stat-label">Call-Offs</div>
            <div class="stat-number"><?= $calloffCount ?></div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Duplicates</div>
            <div class="stat-number"><?= $duplicateCount ?></div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Resolved</div>
            <div class="stat-number"><?= $resolvedCount ?></div>
        </div>

    </div>

    <div class="panel">

        <div class="panel-header">
            <h2>Call-Off Activity</h2>
        </div>

        <div class="table-wrap">

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

                    <tr class="<?= $msg->status === 'CALLOFF' ? 'calloff' : '' ?>">

                        <td>
                            <strong><?= $msg->employee_name ?? 'Unknown' ?></strong>
                        </td>

                        <td>
                            <?= $msg->body ?>
                        </td>

                        <td>
                            <?php if ($msg->status === 'CALLOFF'): ?>
                                <span class="badge badge-red">CALLOFF</span>
                            <?php elseif ($msg->status === 'DUPLICATE'): ?>
                                <span class="badge badge-orange">DUPLICATE</span>
                            <?php else: ?>
                                <span class="badge badge-gray"><?= $msg->status ?? 'N/A' ?></span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= date('m/d/Y g:i A', strtotime($msg->created_at)) ?>
                        </td>

                        <td>
                            <?php if ($msg->acknowledged): ?>
                                <span class="badge badge-green">YES</span>
                            <?php else: ?>
                                <span class="badge badge-gray">NO</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if ($msg->resolved): ?>
                                <span class="badge badge-green">YES</span>
                            <?php else: ?>
                                <span class="badge badge-gray">NO</span>
                            <?php endif; ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>

        </div>

    </div>

    <div class="footer-note">
        Powered by CallOffApp
    </div>

</div>
</div>

</body>
</html>