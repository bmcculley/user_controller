<?php
/*
 * Example for users to verify their account.
 */

session_start();
require_once('../user_controller.php');

$login = new Login();

if( isset($_REQUEST['email']) && isset($_REQUEST['verify']) ) {
	$login->verify_email($_REQUEST['email'], $_REQUEST['verify']);
}
else {
	echo '<strong>email and verification string not set.<strong/>';
}
?>