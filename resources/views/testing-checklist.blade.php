<!DOCTYPE html>
<html>
<head>
    <title>Testing Checklist - CallOffApp</title>

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
            width: 260px;
            background: #0f172a;
            color: white;
            padding: 24px;
        }

        .logo {
            font-size: 34px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #94a3b8;
            margin-bottom: 40px;
        }

        .nav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 10px;
            background: rgba(255,255,255,0.04);
        }

        .nav a:hover {
            background: rgba(255,255,255,0.10);
        }

        .nav .active {
            background: #1e293b;
        }

        .logout-link {
            background: #dc2626 !important;
        }

        .logout-link:hover {
            background: #b91c1c !important;
        }

        .content {
            flex: 1;
            padding: 34px;
        }

        h1 {
            margin-top: 0;
            font-size: 40px;
        }

        .description {
            color: #64748b;
            margin-bottom: 30px;
        }

        .section {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(15,23,42,0.08);
        }

        .section h2 {
            margin-top: 0;
            margin-bottom: 18px;
        }

        .check-item {
            display: flex;
            align-items: center;
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        .check-item:last-child {
            border-bottom: none;
        }

        .checkbox {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            border: 2px solid #cbd5e1;
            margin-right: 14px;
            background: #f8fafc;
        }

        .footer-note {
            text-align: center;
            margin-top: 30px;
            color: #64748b;
            font-size: 13px;
        }

    </style>

</head>

<body>

<div class="layout">

    <div class="sidebar">

        <div class="logo">%</div>

        <div class="subtitle">
            CallOffApp Admin
        </div>

        <div class="nav">

<a class="active" href="/messages">Dashboard</a>
<a href="/calendar">Calendar</a>
<a href="/messages?calloff=1">Call-Off Log</a>

            <a href="/employees">Employees</a>

            <a href="/clients">Clients</a>

            <a href="/send-daily-summary">Daily Summary</a>

            <a href="/testing-checklist" class="active">
                Testing Checklist
            </a>

            <a href="/admin-logout" class="logout-link">
                Logout
            </a>

        </div>

    </div>

    <div class="content">

        <h1>Testing Checklist</h1>

        <div class="description">
            Use this checklist before live staffing company rollout.
        </div>

        <div class="section">

            <h2>Twilio SMS Testing</h2>

            <div class="check-item">
                <div class="checkbox"></div>
                Employee SMS received in dashboard
            </div>

            <div class="check-item">
                <div class="checkbox"></div>
                Call-off detection working
            </div>

            <div class="check-item">
                <div class="checkbox"></div>
                Duplicate detection working
            </div>

            <div class="check-item">
                <div class="checkbox"></div>
                Spanish SMS detection working
            </div>

        </div>

        <div class="section">

            <h2>Voice Call Testing</h2>

            <div class="check-item">
                <div class="checkbox"></div>
                Voice recording saved
            </div>

            <div class="check-item">
                <div class="checkbox"></div>
                OpenAI transcription working
            </div>

            <div class="check-item">
                <div class="checkbox"></div>
                Voice call-offs classified correctly
            </div>

        </div>

        <div class="section">

            <h2>Client Notifications</h2>

            <div class="check-item">
                <div class="checkbox"></div>
                Client email notifications working
            </div>

            <div class="check-item">
                <div class="checkbox"></div>
                Correct client receives alerts
            </div>

            <div class="check-item">
                <div class="checkbox"></div>
                Daily summary page working
            </div>

        </div>

        <div class="section">

            <h2>Security & Admin</h2>

            <div class="check-item">
                <div class="checkbox"></div>
                Admin login protected
            </div>

            <div class="check-item">
                <div class="checkbox"></div>
                Logout working
            </div>

            <div class="check-item">
                <div class="checkbox"></div>
                Protected routes inaccessible when logged out
            </div>

        </div>

        <div class="section">

            <h2>Production Readiness</h2>

            <div class="check-item">
                <div class="checkbox"></div>
                Twilio A2P registration complete
            </div>

            <div class="check-item">
                <div class="checkbox"></div>
                Resend domain verified
            </div>

            <div class="check-item">
                <div class="checkbox"></div>
                Real staffing employees tested
            </div>

            <div class="check-item">
                <div class="checkbox"></div>
                Real staffing client tested
            </div>

        </div>

        <div class="footer-note">
            CallOffApp Testing & Deployment Checklist
        </div>

    </div>

</div>

</body>
</html>