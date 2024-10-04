<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verification Email</title>
    <style>
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            font-family: monospace;
        }

        .header {
            /* text-align: center; */
            padding: 20px;
        }

        .header h1 {
            font-size: 20px;
            color: #333;
        }

        .content {
            padding: 20px;
        }

        .content p {
            margin: 0 0 10px;
            line-height: 1.6;
            font-size: 15px;
        }

        .button {
            display: block;
            width: fit-content;
            /* margin: 20px auto; */
            padding: 10px 20px;
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>OTP Verification</h2>
        </div>
        <div class="content">
            <p style="margin-bottom: 20px">Your Verification OTP Code is </p>
            <p><b>{{ $otp }}</b></p>
        </div>

    </div>
</body>

</html>
