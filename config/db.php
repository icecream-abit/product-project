<?php
$host =	'localhost';
$db	=	'*********';
$user	=	'';


try {
	$pdo = new PDO("pgsql:host=$host;dbname=$db", $user, '');

	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	die("DB connection failed: " . $e->getMessage());
}

?>