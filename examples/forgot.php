<?php
/*
 * Page for users reset forgotten passwords
 */
session_start();
require_once('../user_controller.php');

$login = new Login();

if (isset($_POST['Submit'])) {
	$login->forgot_password($_REQUEST['email']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <style type="text/css">
        /* just for the demo */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 10px;
        }
        label {
            position: relative;
            vertical-align: middle;
            bottom: 1px;
        }
        input[type=text],
        input[type=password],
        input[type=submit],
        input[type=email] {
            display: block;
            margin-bottom: 15px;
        }
        input[type=checkbox] {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>



<form method="post" action="forgot.php">
    <label for="email">Request a password reset. Enter your email and we'll send you an email:</label>
    <input id="email" type="text" name="email" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" />
    <input type="submit" name="Submit" value="Reset my password" />
</form>

<a href="./login.php">Back to Login Page</a>

</body>
</html>
