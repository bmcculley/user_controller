<?php
/*
 * Page for users to login into their accounts
 */
session_start();
require_once('../user_controller.php');

$login = new Login();

if (isset($_POST['Submit'])) {
	$login->user_login($_REQUEST['username'], $_REQUEST['password']);
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

	<body onload='setFocus()'>
		
		<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<fieldset>
				<legend>Login:</legend>
				<label for="username">Username:</label><br/>
				<input type="text" id="username" name="username" size="20" value="<?php echo (isset($_POST['login'])) ? $_POST['login'] : $my_access->user; ?>"><br>
				<label for="password">Password:</label><br/>
				<input type="password" id="password" name="password" size="20" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>"><br>
				<br/>
				<input type="submit" class="submit" name="Submit" value="Login">
			</fieldset>
		</form>
		
		<a href="./register.php">Register new account</a>
		<a href="./forgot.php">Forgot your password?</a>
		
		<script>
		function setFocus(){
		    document.getElementById("username").focus();
		}
		</script>
	</body>
</html>