<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style type="text/css">
        a {
            text-decoration: none;
            -webkit-transition: all .4s ease-in-out;
            -moz-transition: all .4s ease-in-out;
            -o-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
        }

        .res_btn {
            padding: 8px 30px;
            display: inline-block;
            border-radius: 50px;
            background-color: #5fc3d9;
            border: 2px solid #5fc3d9;
            color: #fff;
            font-weight: normal;
            letter-spacing: 1px;
            text-align: center;
            text-transform: uppercase;
            margin-top: 30px;
        }

        .res_btn:hover {
            background-color: transparent;
            color: #5fc3d9;
        }

        .textAfterHeading {
            color: #2a2a2a;
            font-size: 14px;
            text-align: center;
            padding: 10px 15px;
            line-height: 23px;
        }

    </style>
</head>
<body style="background-color: #5fc3d9; height: 100%; margin: 0; padding: 0; width: 100%">
    <div style="font-family: 'Cairo', sans-serif;">
        <table style="display: block">
            <tbody style="display: block">
                <tr style="display: block">
                    <td style="display: block">
                        <table style="width:80%; display: block;margin: auto">
                            <tbody style="display: block;">
                                <tr style="display: block">
                                    <td style="display: block">
                                        <table style="margin-top: 80px;display: block;">
                                            <tbody style="display: block">
                                                <tr style="display: block">
                                                    <td style="background-color: #ffffff;padding: 40px 15px 15px;display: block;">
                                                        <a class="" href="{{ url('/') }}" style="display: block;text-align: center" target="_blank">
                                                            {{-- <img align="center" class="mcnImage" src="{{ asset('images/reset.png') }}" width="250"> --}}
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr style="display: block">
                                                    <td style="background-color: #ffffff;padding: 40px 15px;margin-top: -2px;display: block;">
                                                        <h1 class="null" style='color: #2a2a2a; font-size: 32px; font-style: normal; font-weight: bold; line-height:125%; letter-spacing: 2px; text-align: center; display: block; margin: 0;padding: 0'>
                                                            <span style="text-transform:uppercase">Forgot</span>
                                                        </h1>
                                                        <h2 class="null" style='color: #2a2a2a;font-size: 24px; font-style: normal; font-weight: bold; line-height:125%; letter-spacing: 1px; text-align: center; display: block; margin: 0;padding: 0'>
                                                            <span style="text-transform:uppercase">your password?</span>
                                                        </h2>
                                                        <p class="textAfterHeading">Not to worry, we got you! Let’s get you a new password.</p>
                                                        <div style="text-align: center;">
                                                            <a class="mcnButton res_btn" href="{{ $url }}" target="_blank">Reset password</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr style="display: block;">
                                                    <td style="background-color: #ffffff;padding: 15px;margin-top: 15px;display: block;">
                                                        <p style='margin: 10px 0; padding: 0;color: #2a2a2a; font-size: 14px; '>
                                                            If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
                                                        </p>
                                                        <div style="padding-bottom: 18px;">
                                                            <a href="{{ $url }}" style="color: #5fc3d9; font-weight: normal; text-decoration: none;font-size: 14px;word-break: break-all;" target="_blank">{{ $url }}</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
