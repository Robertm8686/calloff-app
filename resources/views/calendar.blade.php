<!DOCTYPE html>
<html>
<head>
    <title>Calendar</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:Arial;}

        body{background:#f4f6f9;display:flex;}

        .sidebar{
            width:250px;background:#07122b;min-height:100vh;padding:30px 20px;
        }

        .logo{color:white;font-size:32px;font-weight:bold;margin-bottom:40px;}

        .sidebar a{
            display:block;color:white;text-decoration:none;padding:16px;
            margin-bottom:10px;border-radius:12px;
        }

        .sidebar a:hover,.sidebar a.active{background:#16213d;}

        .logout-link{background:#dc2626 !important;}

        .content{flex:1;padding:40px;}

        .page-title{font-size:42px;font-weight:bold;margin-bottom:8px;}

        .page-subtitle{color:#666;margin-bottom:30px;}

        .calendar{
            background:white;border-radius:20px;overflow:hidden;
            box-shadow:0 2px 10px rgba(0,0,0,.08);
        }

        .calendar-header{
            padding:20px;border-bottom:1px solid #eee;
            font-size:24px;font-weight:bold;
        }

        .days,.dates{display:grid;grid-template-columns:repeat(7,1fr);}

        .days{background:#fafafa;border-bottom:1px solid #eee;}

        .day-name{
            padding:15px;text-align:center;font-weight:bold;color:#666;
        }

        .date-box{
            min-height:140px;border-right:1px solid #eee;
            border-bottom:1px solid #eee;padding:10px;background:white;
        }

        .date-number{font-weight:bold;margin-bottom:10px;}

        .calloff{
            background:#fff3e8;color:#d97706;padding:7px;
            border-radius:8px;font-size:12px;margin-bottom:6px;
        }

        .calloff-name{font-weight:bold;}

        .calloff-client{font-size:11px;color:#666;margin-top:2px;}

        .calloff-time{font-size:10px;color:#999;margin-top:2px;}

        .recent{
            margin-top:40px;background:white;padding:25px;
            border-radius:16px;box-shadow:0 2px 10px rgba(0,0,0,.08);
        }

        .recent h2{margin-bottom:20px;}

        .recent-item{
            padding:15px 0;border-bottom:1px solid #eee;
        }

        .recent-item:last-child{border-bottom:none;}

        .recent-name{font-weight:bold;font-size:16px;}

        .recent-client{color:#666;margin-top:4px;}

        .recent-message{margin-top:8px;}

        .recent-time{margin-top:8px;font-size:12px;color:#999;}

        @media(max-width:900px){
            body{display:block;}
            .sidebar{width:100%;min-height:auto;}
            .content{padding:20px;}
            .days,.dates{grid-template-columns:repeat(7, minmax(120px,1fr));}
            .calendar{overflow-x:auto;}
        }
    </style>
</head>

<body>

<div class="sidebar">
    <div class="logo">CallOffApp</div>

    <a href="/messages">Dashboard</a>
    <a class="active" href="/calendar">Calendar</a>
    <a href="/messages?calloff=1">Call-Off Log</a>
    <a href="/employees">Employees</a>
    <a href="/clients">Clients</a>
    <a href="/testing-checklist">Testing Checklist</a>
    <a href="/admin-logout" class="logout-link">Logout</a>
</div>

<div class="content">

    <div class="page-title">Operations Calendar</div>

    <div class="page-subtitle">
        Staffing call-offs by date, employee, client, and time
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

            @for($i = 1; $i <= now()->daysInMonth; $i++)

                <div class="date-box">

                    <div class="date-number">{{ $i }}</div>

                    @foreach($calloffs as $calloff)

                        @if(\Carbon\Carbon::parse($calloff->created_at)->day == $i)

                            <div class="calloff">

                                <div class="calloff-name">
                                    {{ $calloff->employee_name ?? 'Employee' }}
                                </div>

                                <div class="calloff-client">
                                    {{ $calloff->client_name ?? 'Client' }}
                                </div>

                                <div class="calloff-time">
                                    {{ \Carbon\Carbon::parse($calloff->created_at)->format('g:i A') }}
                                </div>

                            </div>

                        @endif

                    @endforeach

                </div>

            @endfor

        </div>

    </div>

    <div class="recent">

        <h2>Recent Call-Off Activity</h2>

        @foreach($calloffs->take(10) as $calloff)

            <div class="recent-item">

                <div class="recent-name">
                    {{ $calloff->employee_name ?? 'Employee' }}
                </div>

                <div class="recent-client">
                    {{ $calloff->client_name ?? 'Client' }}
                </div>

                <div class="recent-message">
                    {{ $calloff->body }}
                </div>

                <div class="recent-time">
                    {{ \Carbon\Carbon::parse($calloff->created_at)->format('M d, Y g:i A') }}
                </div>

            </div>

        @endforeach

    </div>

</div>

</body>
</html>