<?php
/**
 * A Class to control user access to pages on a site.
 * Unlimited access levels.
 * 
 * Source Code URL: https://github.com/bmcculley/user_controller
 * Developer URL: http://bmcculley.github.io
 *
 */

class Login {

	private $con;
	// move salt and default access level to config file
	private $salt = '40be4e59b9a2a2b5dffb918c0e86b3d7';
	private $table_name = 'users';
	private $default_access_level = 1;
	private $password_length = 8;
	private $site_name;
	private $site_email;
	private $verify_page;

	function Login() {
		include_once('../config.php');

		$this->site_name = $site_name;
		$this->site_email = $site_email;
		$this->verify_page = $verification_page;

		$this->db_connect($host, $user, $pass, $db);
	}

	// start a new connection
	private function db_connect($host, $user, $pass, $db) {
		$this->con = mysqli_connect($host, $user, $pass, $db);
	}

	function user_login($username, $password, $referer_page = NULL) {
		$username = mysqli_real_escape_string($this->con, $username);
		$password = md5($password.$this->salt);
		$password = mysqli_real_escape_string($this->con, $password);
		
		$sql = "SELECT * FROM ".$this->table_name." WHERE username = '".$username."' AND password = '".$password."' AND active = 'y' LIMIT 1";

		if(!$result = mysqli_query($this->con,$sql)){
		    die('There was an error running the query [' . $this->con->error . ']');
		}
		else {
			while($row = $result->fetch_assoc()) {
			    $this->set_user($row['username'], $row['access_level']);
			    if ( isset($referer_page) ) {
			    	header('Location: '.$referer_page);
			    }
			    else {
			    	header('Location: ./');
			    }
			}
		}

		mysqli_close($this->con);
	}

	function user_register($email, $username, $password) {
		// check if the email is valid
		if( $this->valid_email($email) ) {
			// email is valid, continue with registeration
			$email = mysqli_real_escape_string($this->con, $email);
			$username = mysqli_real_escape_string($this->con, $username);

			// create a verification hash to be stored and sent as part of the verify link
			$verify_string = md5( rand(0,1000) );
			$verify_string = mysql_escape_string($verify_string);
			$verify_string = urlencode($verify_string);

			// check that the email or username doesn't already exist in database
			if( $this->check_user($email, $username) ) {
				// user already exists
				return False;
			}
			elseif ( !$this->password_strength($password) ) {
				// password is too short/weak
				return False;
			}
			else {
				$password = md5($password.$this->salt);
				$password = mysqli_real_escape_string($this->con, $password);
				$sql = "INSERT INTO ".$this->table_name." (id, username, password, email, verify_string, access_level, active) 
							VALUES (NULL, 
								'".$username."',
								'".$password."',
								'".$email."',
								'".$verify_string."',
								'".$this->default_access_level."',
								'n'
								)";
				
				if(!$result = mysqli_query($this->con,$sql)){
				    die('There was an error running the query [' . $this->con->error . ']');
				}
				else {
					// set a page to redirect user to
					$this->send_email($email, $verify_string);
					header('Location: ./login.php');
					return True;
				}

				mysqli_close($this->con);
			}

		}
		else {
			// email address is no good, do not register
			echo 'bad email address';
			return False;
		}

	}

	private function password_strength($password) {
		$returnVal = True;

		if ( strlen($password) < $this->password_length ) {
			$returnVal = False;
		}

		if ( !preg_match("#[0-9]+#", $password) ) {
			$returnVal = False;
		}

		if ( !preg_match("#[a-z]+#", $password) ) {
			$returnVal = False;
		}

		if ( !preg_match("#[A-Z]+#", $password) ) {
			$returnVal = False;
		}

		if ( !preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $password) ) {
			$returnVal = False;
		}

		return $returnVal;

	}

	function forgot_password($email) {
		// check if username or email exists in database send password reset accordingly
		if( isset($email) && $this->valid_email($email) ) {

			$email = mysqli_real_escape_string($this->con, $email);
			$sql = "SELECT * FROM ".$this->table_name." WHERE email = '".$email."' AND active = 'y' LIMIT 1";

			if(!$result = mysqli_query($this->con,$sql)){
			    return False;
			}
			else {
				$newPass = $this->new_password();
				$encryptNewPass = md5($newPass.$this->salt);
				$sql = "UPDATE ".$this->table_name." SET password='".$encryptNewPass."' WHERE email='".$email."' LIMIT 1";

				if(!$result = mysqli_query($this->con,$sql)){
				    return False;
				}
				else {
					while($row = $result->fetch_assoc()) {
					
					    $username = $row['username'];
					    //echo $username;
					    
					} 
					// set a page to redirect user to
					$this->send_email($email, NULL, $username, $newPass);
					header('Location: ./login.php');
					return True;
				}
			}

			mysqli_close($this->con);
		}
		else {
			// error
			return False;
		}

	}

	private function new_password($length = 9, $add_dashes = false, $available_sets = 'luds') {

		$sets = array();
		if(strpos($available_sets, 'l') !== false)
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		if(strpos($available_sets, 'u') !== false)
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if(strpos($available_sets, 'd') !== false)
			$sets[] = '23456789';
		if(strpos($available_sets, 's') !== false)
			$sets[] = '!@#$%&*?';

		$all = '';
		$password = '';
		foreach($sets as $set) {
			$password .= $set[array_rand(str_split($set))];
			$all .= $set;
		}

		$all = str_split($all);
		for($i = 0; $i < $length - count($sets); $i++)
			$password .= $all[array_rand($all)];

		$password = str_shuffle($password);

		if(!$add_dashes)
			return $password;

		$dash_len = floor(sqrt($length));
		$dash_str = '';
		while(strlen($password) > $dash_len) {
			$dash_str .= substr($password, 0, $dash_len) . '-';
			$password = substr($password, $dash_len);
		}
		
		$dash_str .= $password;
		return $dash_str;
	}

	function change_password($curPass, $newPass, $newPassVerify) {
		// check that the curPass matches current password then set to new one
		$username = mysqli_real_escape_string($this->con, $_SESSION['username']);
		$curPass = md5($curPass.$this->salt);
		$curPass = mysqli_real_escape_string($this->con, $curPass);
		
		$sql = "SELECT * FROM users WHERE username = '".$username."' AND password = '".$curPass."' AND active = 'y' LIMIT 1";

		if(!$result = mysqli_query($this->con,$sql)){
		    die('There was an error running the query [' . $this->con->error . ']');
		}
		else {
			if ( !$this->password_strength($newPass) ) {
				return False;
			}
			elseif ( $newPass != $newPassVerify ) {
				return False;
			}
			else {
				$newPass = md5($newPass.$this->salt);
				$newPass = mysqli_real_escape_string($this->con, $newPass);

				$sql = "UPDATE ".$this->table_name." SET password='".$newPass."' WHERE username = '".$username."' AND password='".$curPass."' LIMIT 1";

				if(!$result = mysqli_query($this->con,$sql)){
					return False;
				}
				else {
					header('Location: ./login.php');
				    return True;
				}
			}

		}

		mysqli_close($this->con);
	}

	private function set_user($username, $access_level) {
		setcookie('user', $username);
		$_SESSION['username'] = $username;
		$_SESSION['access_level'] = $access_level;
	}

	function access_level() {
		if (isset($_SESSION['access_level'])) {
			return $_SESSION['access_level'];
		}
		else {
			return 0;
		}
	}

	private function check_user($email, $username) {
		
		$sql = "SELECT * FROM ".$this->table_name." WHERE email = '".$email."' AND username = '".$username."' LIMIT 1";

		if(!$result = mysqli_query($this->con,$sql)){
		    return True;
		}
		else {
			return False;
		}

		mysqli_close($this->con);
	}

	function user_logout() {
		unset($_COOKIE['user']);
		unset($_SESSION['username']);
		unset($_SESSION['access_level']);
		session_destroy();
		header('Location: ./');
	}

	private function valid_email($email) {
		
		if ( version_compare(phpversion(), '5.2.0', '<') ) {
		    // php version isn't high enough
		    $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
		    if ( preg_match($pattern, $email) ) {
			    return True;
			}
		}
		else {
			if ( filter_var($email, FILTER_VALIDATE_EMAIL) ) {
			    return True;
			}
		}
	}

	private function send_email($email, $verify_string = NULL, $username = NULL, $newPass = NULL) {
		// function to send verification email
		$urlsafe_email = urldecode($email);

		$header = "From: \"".$this->site_name."\" <".$this->site_email.">\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Mailer: User Controller Script version 0.1\r\n";
		$header .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n";

		if ( isset($verify_string) ) {
			$subject = "Welcome to our site";
			$body = "New user registration on ".date("Y-m-d").":\r\n\r\nClick here to enter the verify your email address:\r\n\r\n"."http://".$_SERVER['HTTP_HOST'].$this->verify_page."?email=".$urlsafe_email."verify=".$verify_string;
		}
		else {
			$subject = "New Password for".$this->site_name;
			$body = "Your password has been reset on ".date("Y-m-d").":\r\n\r\nYour username: ".$username."\r\n\r\nYour password: ".$newPass;
		}
		
		if (mail($mail_address, $subject, $body, $header)) {
			return true;
		} 
		else {
			return false;
		}

	}

	function verify_email($email, $verify_string) {
		
		$sql = "UPDATE ".$this->table_name." SET active='y' WHERE email='".$email."' AND verify_string='".$verify_string."' LIMIT 1";

		if(!$result = mysqli_query($this->con,$sql)){
		    return True;
		}
		else {
			return False;
		}

		mysqli_close($this->con);
	}

}
?>