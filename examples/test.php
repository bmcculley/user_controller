<?php
/*
 * Page to test user level and see username
 */
session_start();
require_once('../user_controller.php');
$logged_in = new Login();
$lvl = $logged_in->access_level();
if ($lvl <= 0) {
    header('Location: ./login.php');
}
echo 'Howdy, '.($_COOKIE['user']!='' ? $_COOKIE['user'] : 'Guest').'<br/>';
echo 'User Level: '.$lvl.'<br/>';
?>
<a href="./logout.php">Logout</a>