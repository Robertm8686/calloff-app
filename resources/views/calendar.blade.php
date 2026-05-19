<!DOCTYPE html>
<html>
<head>
    <title>Calendar</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial;
        }

        body{
            background:#f4f6f9;
            display:flex;
        }

        .sidebar{
            width:250px;
            background:#07122b;
            min-height:100vh;
            padding:30px 20px;
        }

        .logo{
            color:white;
            font-size:32px;
            font-weight:bold;
            margin-bottom:40px;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:16px;
            margin-bottom:10px;
            border-radius:12px;
        }

        .sidebar a:hover{
            background:#16213d;
        }

        .content{
            flex:1;
            padding:40px;
        }

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        .calendar{
            background:white;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 2px 10px rgba(0,0,0,.08);
        }

        .calendar-header{
            padding:20px;
            border-bottom:1px solid #eee;
            font-size:24px;
            font-weight:bold;
        }

        .days{
            display:grid;
            grid-template-columns:repeat(7,1fr);
            background:#fafafa;
            border-bottom:1px solid #eee;
        }

        .day-name{
            padding:15px;
            text-align:center;
            font-weight:bold;
            color:#666;
        }

        .dates{
            display:grid;
            grid-template-columns:repeat(7,1fr);
        }

        .date-box{
            min-height:140px;
            border-right:1px solid #eee;
            border-bottom:1px solid #eee;
            padding:10px;
            position:relative;
            background:white;
        }

        .date-number{
            font-weight:bold;
            margin-bottom:10px;
        }

        .calloff{
            background:#fff3e8;
            color:#d97706;
            padding:6px;
            border-radius:8px;
            font-size:12px;
            margin-bottom:6px;
        }

        .client{
            font-size:11px;
            color:#666;
            margin-top:2px;
        }

        .page-title{
            font-size:42px;
            font-weight:bold;
            margin-bottom:8px;
        }

        .page-subtitle{
            color:#666;
            margin-bottom:30px;
        }

    </style>

</head>
<body>

<div class="sidebar">

    <div class="logo">
        CallOffApp
    </div>

    <a href="/messages">Dashboard</a>
    <a href="/calendar">Calendar</a>
    <a href="/calloff-log">Call-Off Log</a>
    <a href="/employees">Employees</a>
    <a href="/clients">Clients</a>
    <a href="/testing-checklist">Testing Checklist</a>

</div>

<div class="content">

    <div class="page-title">
        Operations Calendar
    </div>

    <div class="page-subtitle">
        Staffing call-offs by date and client
    </div>

    <div class="calendar">

        <div class="calendar-header">
            {{ now()->format('F Y') }}
        </div>

        <div class="days">

            <div class="day-name">Sun</div>
            <div class="day-name">Mon</div>
            <div class="day-name">Tue</div>
            <div class="day-name">Wed</div>
            <div class="day-name">Thu</div>
            <div class="day-name">Fri</div>
            <div class="day-name">Sat</div>

        </div>

        <div class="dates">

            @for($i = 1; $i <= 31; $i++)

                <div class="date-box">

                    <div class="date-number">
                        {{ $i }}
                    </div>

                    @foreach($calloffs as $calloff)

                        @if(\Carbon\Carbon::parse($calloff->created_at)->day == $i)

                            <div class="calloff">

                                {{ $calloff->employee_name ?? 'Employee' }}

                                <div class="client">
                                    {{ $calloff->client_name ?? 'Client' }}
                                </div>

                            </div>

                        @endif

                    @endforeach

                </div>

            @endfor

        </div>

    </div>

</div>

</body>
</html>