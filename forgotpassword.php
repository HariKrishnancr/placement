<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Placement Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/AdminLTE.min.css"> <script src="https://cdn.tailwindcss.com"></script> <style>
        /* Base styles from your provided code or similar to the image */
        body {
            font-family: 'Source Sans Pro', sans-serif; /* Adjust if your actual font is different */
            background-color: #e3f2fd; /* Light blue similar to bg-blue-100 */
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensures content pushes footer down */
            margin: 0;
            padding: 0;
        }

        .main-content {
            flex-grow: 1; /* Allows this section to take available space */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px; /* Add some padding around the content */
        }

        .login-box {
            width: 360px; /* Slightly wider to match your image's container width */
            background: #ffffff; /* White background for the main box */
            border-top: 3px solid #3c8dbc; /* Blue border-top similar to AdminLTE login */
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            border-radius: 4px; /* Slight border radius */
            padding: 20px 30px; /* Adjust padding as needed */
        }

        .login-box-body {
            background: #f8fafd; /* Light blue background for the inner content, similar to your login image */
            padding: 25px 20px;
            border-top-left-radius: 2px;
            border-top-right-radius: 2px;
        }

        .login-box-msg {
            margin: 0;
            text-align: center;
            padding: 0 20px 20px 20px;
            color: #444;
            font-size: 16px;
        }

        h1.portal-title {
            font-size: 38px; /* Larger font for main title */
            color: #333; /* Darker text */
            margin-bottom: 30px; /* Space below title */
            font-weight: 600; /* Semi-bold */
        }

        .form-group {
            margin-bottom: 15px;
            position: relative; /* For icon positioning */
        }

        .form-control {
            border-radius: 3px;
            box-shadow: none;
            border-color: #d2d6de;
            height: 38px; /* Standard height */
            padding-left: 15px; /* Adjust for icon if present */
            font-size: 15px;
        }

        .form-control:focus {
            border-color: #3c8dbc; /* AdminLTE focus color */
            box-shadow: 0 0 0 0.2rem rgba(60, 141, 188, 0.25); /* Bootstrap-like focus glow */
        }

        .form-control-feedback {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 2;
            display: block;
            width: 34px; /* Icon width */
            height: 34px; /* Icon height */
            line-height: 34px; /* Center icon vertically */
            text-align: center;
            color: #999;
            font-size: 18px; /* Larger icon */
            pointer-events: none; /* Allows clicks to pass through to input */
        }

        .btn-primary {
            background-color: #605ca8; /* Deeper purple, matching your image's button */
            border-color: #605ca8;
            color: #fff;
            padding: 8px 15px;
            font-size: 16px;
            border-radius: 3px;
            width: 100%; /* Full width button */
        }

        .btn-primary:hover,
        .btn-primary:active,
        .btn-primary.hover {
            background-color: #534f96; /* Darker on hover */
            border-color: #534f96;
        }

        .help-block {
            color: #a94442; /* Error message color */
            font-size: 13px;
            margin-top: 5px;
        }

        .text-center {
            text-align: center;
        }

        .login-link {
            display: block;
            margin-top: 15px;
            color: #000; /* Black for links */
            text-decoration: none;
            font-size: 14px;
        }

        .login-link:hover {
            color: #3c8dbc; /* Hover color similar to AdminLTE */
            text-decoration: underline;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Optional: Adjust header and footer placeholder height if needed */
        .header-placeholder, .footer-placeholder {
            min-height: 60px; /* Example height */
            width: 100%;
            background-color: transparent; /* Or a light color to see the space */
        }
    </style>
</head>
<body class="bg-blue-100">

  <?php

  include 'php/head.php'

  ?>
</head>
    <div class="header-placeholder">
        <?php include('php/header.php'); ?>
    </div>

    <div class="main-content">
        <h1 class="portal-title">Placement Portal</h1>

        <div class="login-box">
            <div class="login-box-body">
                <p class="login-box-msg">Forgot Your Password?</p>
                <p class="text-center" style="margin-bottom: 20px; font-size: 14px; color: #666;">
                    Enter your email to receive a password reset link.
                </p>

                <?php 
                // PHP logic to handle messages
                $message_output = '';
                if (!empty($message)) {
                    $message_class = (strpos($message, 'created') !== false || strpos($message, 'sent') !== false) ? 'success' : 'error';
                    $message_output = "<div class='message {$message_class}'>{$message}</div>";
                }
                echo $message_output;
                ?>

                <form method="POST" action="">
                    <div class="form-group has-feedback">
                        <input type="email" name="email" class="form-control" placeholder="Email" required autocomplete="email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Send Reset Link</button>
                        </div>
                    </div>
                </form>

                <div class="text-center">
                    <a href="index.php" class="login-link">Back to Login</a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-placeholder">
        <?php include('php/footer.php'); ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>
</html>