<?php
/*
 * Page for new users to register an account
 */
session_start();
require_once('../user_controller.php');

$login = new Login();

if (isset($_POST['Submit'])) {
	$login->user_register($_REQUEST['useremail'],$_REQUEST['username'],$_REQUEST['userpassword']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration Example</title>
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

<!-- show registration form, but only if we didn't submit already -->
<form method="post" action="register.php">
    <label for="username">Username (only letters and numbers, 2 to 64 characters)</label>
    <input id="username" type="text" pattern="[a-zA-Z0-9]{2,64}" name="username" required />

    <label for="useremail">User's email (please provide a real email address, you'll get a verification mail with an activation link)</label>
    <input id="useremail" type="email" name="useremail" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" />

    <label for="userpassword">Password (min. 8 characters!)</label>
    <input id="userpassword" type="password" name="userpassword" required autocomplete="off" />

    <input type="submit" name="Submit" value="Register" />
</form>

    <a href="./login.php">Back to Login Page</a>

</body>
</html>
