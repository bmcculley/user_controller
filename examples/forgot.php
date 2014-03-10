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
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Forgot Password Example</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <style type="text/css">
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