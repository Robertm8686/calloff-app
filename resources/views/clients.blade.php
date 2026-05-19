<!DOCTYPE html>
<html>
<head>
    <title>Clients - CallOffApp</title>

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

        .subtitle {
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
        }

        .button.secondary {
            background: #64748b;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            min-width: 1000px;
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

        .action-link {
            color: #2563eb;
            font-weight: bold;
            text-decoration: none;
        }

        .pill {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .pill-green {
            background: #dcfce7;
            color: #166534;
        }

        .pill-gray {
            background: #e5e7eb;
            color: #374151;
        }

        @media (max-width: 900px) {

            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
            }

            .content {
                padding: 20px;
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
            <a href="/messages">Dashboard</a>
            <a href="/messages?calloff=1">Call-Off Log</a>
            <a href="/employees">Employees</a>
            <a class="active" href="/clients">Clients</a>
            <a href="/send-daily-summary">Daily Summary</a>
        </nav>

    </aside>

    <main class="content">

        <div class="topbar">

            <div>
                <h1>Clients</h1>
                <div class="subtitle">
                    Manage staffing clients and notification settings
                </div>
            </div>

            <a class="button" href="/clients/create">
                Add New Client
            </a>

        </div>

        <div class="panel">

            <div class="panel-header">
                <h2>Client Directory</h2>

                <a class="button secondary" href="/messages">
                    Back to Dashboard
                </a>
            </div>

            <div class="table-wrap">

                <table>

                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Notification Email</th>
                        <th>Email Alerts</th>
                        <th>SMS Alerts</th>
                        <th>Action</th>
                    </tr>

                    @foreach($clients as $client)

                    <tr>

                        <td>{{ $client->id }}</td>

                        <td>
                            <strong>{{ $client->name }}</strong>
                        </td>

                        <td>{{ $client->email }}</td>

                        <td>
                            {{ $client->notification_email }}
                        </td>

                        <td>

                            @if($client->notify_email)
                                <span class="pill pill-green">Enabled</span>
                            @else
                                <span class="pill pill-gray">Disabled</span>
                            @endif

                        </td>

                        <td>

                            @if($client->notify_sms)
                                <span class="pill pill-green">Enabled</span>
                            @else
                                <span class="pill pill-gray">Disabled</span>
                            @endif

                        </td>

                        <td>

                            <a class="action-link"
                               href="/clients/{{ $client->id }}/edit">
                                Edit
                            </a>

                            |

                            <a class="action-link"
                               href="/clients/delete/{{ $client->id }}"
                               onclick="return confirm('Delete this client?')">

                                Delete

                            </a>

                        </td>

                    </tr>

                    @endforeach

                </table>

            </div>

        </div>

    </main>

</div>

</body>
</html>