<?php
/*
 * Page for users to login into their accounts
 */
session_start();
require_once('../user_controller.php');

$login = new Login();

if (isset($_POST['Submit'])) {
    if ( isset($_REQUEST['remember'])) {
        $remember = $_REQUEST['remember'];
    } else {
        $remember = False;
    }
	$login->user_login($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['next'], $remember);
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
		<title>Login Example</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<style type="text/css">
        body {
            color: #333;
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 10px;
        }
        .login-form {
            max-width: 300px;
            margin: 0 auto;
            width: 100%;
        }
        .msg {
            border: 1px solid #ccc;
            margin: 5px 0;
            padding: 5px;
            border-radius: 5px;
            width: 80%;
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

	<body onload='setFocus()'>
		<div class="login-form">
            <h1>Please Login</h1>
            <?php 
            if ( $login->error_exists() != '' ) { ?>
            <div class="msg">
                <?php echo $login->error_exists(); ?>
            </div>
            <?php } ?>
            <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    			<label for="username">Username:</label><br/>
    			<input type="text" id="username" name="username" size="20" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"><br>
    			<label for="password">Password:</label><br/>
    			<input type="password" id="password" name="password" size="20" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>">
    			<input type="hidden" id="next" name="next" value="<?php if (isset($_GET['next'])) echo $_GET['next']; ?>">
                <input type="checkbox" name="remember" value="1">Remember Me<br/>
                <input type="submit" class="submit" name="Submit" value="Login">
    		</form>
    		
    		<a href="./register.php">Register new account</a>
    		<a href="./forgot.php">Forgot your password?</a>
		</div>
		<script>
		function setFocus(){
		    document.getElementById("username").focus();
		}
		</script>
	</body>
</html>