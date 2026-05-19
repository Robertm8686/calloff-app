<!DOCTYPE html>
<html>
<head>
    <title>CallOffApp Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #111827;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #0f172a;
            color: white;
            padding: 24px 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 35px;
        }

        .brand-icon {
            background: #f59e0b;
            color: #111827;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 22px;
        }

        .brand-title {
            font-size: 20px;
            font-weight: bold;
        }

        .brand-subtitle {
            color: #94a3b8;
            font-size: 13px;
        }

        .nav a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .nav a.active,
        .nav a:hover {
            background: #1e293b;
            color: white;
        }

        .content {
            flex: 1;
            padding: 34px;
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

        .date {
            color: #6b7280;
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
            border: none;
            cursor: pointer;
        }

        .button.secondary {
            background: #64748b;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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

        .stat-note {
            color: #64748b;
            font-size: 14px;
            margin-top: 6px;
        }

        .panel {
            background: white;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15,23,42,0.08);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .panel-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .search-box {
            padding: 18px 24px;
            border-bottom: 1px solid #e5e7eb;
        }

        .search-box input {
            padding: 12px;
            width: 330px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 14px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
        }

        th {
            background: #111827;
            color: white;
            padding: 14px;
            text-align: left;
            font-size: 14px;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
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

        .badge-gray {
            background: #e5e7eb;
            color: #374151;
        }

        .badge-green {
            background: #16a34a;
            color: white;
        }

        .action-link {
            color: #2563eb;
            font-weight: bold;
            text-decoration: none;
        }

        .summary-list {
            padding: 20px 24px;
        }

        .summary-list li {
            margin-bottom: 8px;
        }
.logout-link {
    background: #dc2626 !important;
    color: white !important;
}

.logout-link:hover {
    background: #b91c1c !important;
}

        @media (max-width: 900px) {
            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .content {
                padding: 20px;
            }
        }

        @media (max-width: 600px) {
            .cards {
                grid-template-columns: 1fr;
            }

            .topbar {
                display: block;
            }

            .topbar .button {
                margin-top: 15px;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">%</div>
            <div>
                <div class="brand-title">CallOffApp</div>
                <div class="brand-subtitle">Call-Off Manager</div>
            </div>
        </div>

        <nav class="nav">
            <a class="active" href="/messages">Dashboard</a>
            <a href="/messages?calloff=1">Call-Off Log</a>
            <a href="/employees">Employees</a>
            <a href="/clients">Clients</a>
            <a href="/send-daily-summary">Daily Summary</a>
<a href="/admin-logout" class="logout-link">
    Logout
</a>
        </nav>
    </aside>

    <main class="content">

        <div class="topbar">
            <div>
                <h1>Dashboard</h1>
                <div class="date"><?= date('l, F j, Y') ?></div>
            </div>

            <a class="button" href="/messages?calloff=1">View Call-Offs</a>
        </div>

        <div class="cards">
            <div class="stat-card">
                <div class="stat-label">Today</div>
                <div class="stat-number"><?= $todayCalloffs ?></div>
                <div class="stat-note">call-offs today</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Clients</div>
                <div class="stat-number"><?= count($clientSummary) ?></div>
                <div class="stat-note">with call-offs</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Messages</div>
                <div class="stat-number"><?= count($messages) ?></div>
                <div class="stat-note">total records shown</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Status</div>
                <div class="stat-number">Live</div>
                <div class="stat-note">Twilio connected</div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2>Search Messages</h2>
            </div>

            <div class="search-box">
                <form method="GET" action="/messages">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search employee, phone, or client..."
                        value="<?= $_GET['search'] ?? '' ?>"
                    >
                    <button type="submit" class="button">Search</button>
                    <a class="button secondary" href="/messages">Reset</a>
                </form>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2>Call-Offs by Client</h2>
            </div>

            <div class="summary-list">
                <?php if (count($clientSummary) === 0): ?>
                    <p>No call-offs today</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($clientSummary as $client): ?>
                            <li>
                                <strong><?= $client->client_name ?? 'Unknown' ?></strong>:
                                <?= $client->total ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2>Messages</h2>
            </div>

            <div class="table-wrap">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>From</th>
                        <th>Employee</th>
                        <th>Client</th>
                        <th>Message</th>
                        <th>Recording</th>
                        <th>Transcription</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th>Acknowledged</th>
                        <th>Resolved</th>
                        <th>Action</th>
                    </tr>

                    <?php foreach ($messages as $msg): ?>
                        <tr class="<?= $msg->status === 'CALLOFF' ? 'calloff' : '' ?>">
                            <td><?= $msg->id ?></td>
                            <td><?= $msg->from ?></td>
                            <td><?= $msg->employee_name ?? 'Unknown' ?></td>
                            <td><?= $msg->client_name ?? 'N/A' ?></td>
                            <td><?= $msg->body ?></td>

                            <td>
                                <?php if (!empty($msg->recording_url)): ?>
                                    <a class="action-link" href="<?= $msg->recording_url ?>" target="_blank">Listen</a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($msg->transcription)): ?>
                                    <?= $msg->transcription ?>
                                <?php else: ?>
                                    <?= $msg->transcription_status ?? 'pending' ?>
                                <?php endif; ?>
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

                            <td><?= date('m/d/Y g:i A', strtotime($msg->created_at)) ?></td>

                            <td>
                                <?php if ($msg->acknowledged): ?>
                                    <span class="badge badge-green">YES</span><br>
                                    <?= date('m/d/Y g:i A', strtotime($msg->acknowledged_at)) ?>
                                <?php else: ?>
                                    <span class="badge badge-gray">NO</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($msg->resolved): ?>
                                    <span class="badge badge-green">YES</span><br>
                                    <?= date('m/d/Y g:i A', strtotime($msg->resolved_at)) ?>
                                <?php else: ?>
                                    <span class="badge badge-gray">NO</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!$msg->acknowledged && $msg->status === 'CALLOFF'): ?>
                                    <a class="action-link" href="/messages/<?= $msg->id ?>/acknowledge">Acknowledge</a>
                                <?php elseif ($msg->acknowledged && !$msg->resolved && $msg->status === 'CALLOFF'): ?>
                                    <a class="action-link" href="/messages/<?= $msg->id ?>/resolve">Resolve</a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </table>
            </div>
        </div>

    </main>

</div>

</body>
</html>