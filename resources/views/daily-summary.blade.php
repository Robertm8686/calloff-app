<!DOCTYPE html>
<html>
<head>
    <title>Daily Summary</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 40px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 30px;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(15,23,42,0.08);
        }

        h1 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
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

        .badge {
            background: #dc2626;
            color: white;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: bold;
        }

    </style>

</head>

<body>

<div class="card">

    <h1>Daily Call-Off Summary</h1>

    <p><?= date('l, F j, Y') ?></p>

    <?php if(count($calloffs) === 0): ?>

        <p>No call-offs today.</p>

    <?php else: ?>

        <table>

            <tr>
                <th>Employee</th>
                <th>Client</th>
                <th>Message</th>
                <th>Status</th>
                <th>Time</th>
            </tr>

            <?php foreach($calloffs as $c): ?>

            <tr>

                <td><?= $c->employee_name ?? 'Unknown' ?></td>

                <td><?= $c->client_name ?? 'N/A' ?></td>

                <td><?= $c->body ?></td>

                <td>
                    <span class="badge">
                        CALLOFF
                    </span>
                </td>

                <td>
                    <?= date('g:i A', strtotime($c->created_at)) ?>
                </td>

            </tr>

            <?php endforeach; ?>

        </table>

    <?php endif; ?>

</div>

</body>
</html>