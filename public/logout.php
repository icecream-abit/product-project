<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	$_SESSION = [];
	session_destroy();
	header("Location: login.php");
	exit;
} else {
	header("Location: /dashboard.php");
}
?>