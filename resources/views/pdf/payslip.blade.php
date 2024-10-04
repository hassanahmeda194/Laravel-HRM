<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OneClick PaySlip</title>
    <style>
        .container {
            margin-top: 5rem;
            margin-left: auto;
            margin-right: auto;
            width: 90%;
            padding-top: 5rem;
        }

        .img-fluid {
            width: 180px;
            height: 90px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-5 {
            margin-bottom: 1.5rem;
        }

        .mt-4 {
            margin-top: 2rem;
        }

        .table-bordered {
            border: 1px solid black;
        }

        .border-black {
            border-color: black;
        }

        tr td {
            border: 1px solid black;
            padding: 8px 6px;
        }

        .bg-primary {
            background-color: #556ee6;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }
    </style>
</head>

<body style="font-family: sans-serif; font-size: 14px;">
    <div class="container">

        <h3 style="margin-bottom:20px;">Payslip</h3>
        <div class="mt-4">
            <table class="table table-bordered border-black">
                <tr>
                    <td colspan="1">Pay Month</td>
                    <td colspan="3">{{ $currentMonth }}</td>
                </tr>
                <tr>
                    <td colspan="1">Payment Method</td>
                    <td colspan="3">Online bank transfer</td>
                </tr>
                <tr>
                    <td class="bg-primary" colspan="4">Employee Detail</td>
                </tr>
                <tr>
                    <td colspan="1">Employee Name</td>
                    <td colspan="3">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td colspan="1">Employee ID</td>
                    <td colspan="3">{{ $user->Emp_Id }}</td>
                </tr>
                <tr>
                    <td colspan="1">Designation </td>
                    <td colspan="3">{{ $user->designation->name }}</td>
                </tr>
                <tr class="bg-primary">
                    <td>Earning</td>
                    <td>Amount (PKR)</td>
                    <td>Deduction</td>
                    <td>Amount (PKR)</td>
                </tr>
                <tr>
                    <td>Basic Pay</td>
                    <td>{{ $basicSalarywithoutDetaction }}</td>
                    <td>Leave Without Pay: {{ $unpaid_Leave_Count }}</td>
                    <td>{{ $leaveDetact }} </td>
                </tr>
                <tr>
                    <td>Bonus</td>
                    <td>{{ $monthlyAllowance }}</td>
                    <td>Half days: {{ $halfDay_Count }}</td>
                    <td> {{ $halfdaydetaction }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Total Earning</td>
                    <td>{{ $basicSalarywithoutDetaction + $monthlyAllowance }}</td>
                    <td>Total Deduction</td>
                    <td>{{ $leaveDetact + $halfdaydetaction }}</td>
                </tr>
                <tr>
                    <td colspan="3">Net Salary</td>
                    <td>{{ $basicSalarywithoutDetaction + $monthlyAllowance - ($leaveDetact + $halfdaydetaction) }}
                    </td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
