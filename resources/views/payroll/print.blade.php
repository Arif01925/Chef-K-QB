<!DOCTYPE html>
<html>
<head>
    <title>Payroll Summary - Chef K</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 30px;
            color: #333;
        }
        .logo {
            text-align: center;
        }
        .logo img {
            height: 100px;
        }
        h2 {
            text-align: center;
            color: #b28a00;
            margin-bottom: 5px;
        }
        h4 {
            text-align: center;
            margin-top: 0;
            font-weight: normal;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px 12px;
            text-align: center;
        }
        th {
            background-color: #f8f0cc;
            color: #333;
        }
        .total-row {
            font-weight: bold;
            background-color: #fffbe6;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="logo">
        <img src="https://mcusercontent.com/f2f8f3acd26a96e38ec184680/images/44148a42-15e2-b62d-a079-1618e103e035.png" alt="Chef K Logo" style="height: 100px;">

    </div>

    <h2>Payroll Summary Report</h2>
    <h4>Period: {{ \Carbon\Carbon::parse($startDate)->format('F d, Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }}</h4>
    <h4>Employee: {{ $employee->name }}</h4>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>In Time</th>
                <th>Out Time</th>
                <th>Hours</th>
                <th>Daily Pay</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->work_date }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->in_time)->format('h:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->out_time)->format('h:i A') }}</td>
                    <td>{{ $record->total_hours }}</td>
                    <td>${{ number_format($record->daily_pay, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Total Pay:</td>
                <td>${{ number_format($totalPay, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Prepared on: {{ now()->format('F d, Y') }}
    </div>

</body>
</html>
