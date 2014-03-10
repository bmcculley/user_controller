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
<html>
<head>
    <meta charset="UTF-8">
    <title>Set New Password</title>
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
