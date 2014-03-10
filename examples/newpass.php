<?php
/*
 * Page for users reset forgotten passwords
 */
session_start();
require_once('../user_controller.php');

$login = new Login();

if (isset($_POST['Submit'])) {
	$login->change_password($_REQUEST['curPass'], $_REQUEST['newPass'], $_REQUEST['newVerify']);
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
        <title>Set New Password Example</title>
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

        <form method="post" action="newpass.php">
            <label for="curPass">Current Password</label>
            <input id="curPass" type="password" name="curPass" required autocomplete="off" />
            <label for="newPass">New Password</label>
            <input id="newPass" type="password" name="newPass" required autocomplete="off" />
            <label for="newVerify">Repeat New Password</label>
            <input id="newVerify" type="password" name="newVerify" required autocomplete="off" />
            <input type="submit" name="Submit" value="Save new password" />
        </form>

        <a href="./login.php">Back to Login Page</a>

    </body>
</html>
