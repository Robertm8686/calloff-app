<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - CallOffApp</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: white;
            width: 420px;
            border-radius: 18px;
            padding: 40px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.25);
        }

        .logo {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            background: #f59e0b;
            color: #111827;
            font-size: 34px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
        }

        h1 {
            margin: 0;
            text-align: center;
            font-size: 32px;
            color: #111827;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-top: 10px;
            margin-bottom: 35px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #111827;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            margin-bottom: 22px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
        }

        .button {
            width: 100%;
            border: none;
            background: #111827;
            color: white;
            padding: 15px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .button:hover {
            background: #1e293b;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            color: #94a3b8;
            font-size: 13px;
        }

    </style>

</head>

<body>

<div class="login-card">

    <div class="logo">%</div>

    <h1>Admin Login</h1>

    <div class="subtitle">
        CallOffApp Operations Dashboard
    </div>

    <form method="POST" action="/admin-login">

        @csrf

        <label>Email</label>

        <input
            type="email"
            name="email"
            placeholder="Enter admin email"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Enter password"
            required
        >

        <button class="button" type="submit">
            Login
        </button>

    </form>

    <div class="footer">
        Staffing Operations Management System
    </div>

</div>

</body>
</html>