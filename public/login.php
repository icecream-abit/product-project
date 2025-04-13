<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();

	include '../config/db.php';
	$username = trim($_POST['username']);
	$password = $_POST['password'];

	$stmt = $pdo->prepare("SELECT id, username, password_digest, role FROM users WHERE username = ?");
	$stmt->execute([$username]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user && password_verify($password, $user['password_digest'])){
     $_SESSION['user_id'] = $user['id'];
     $_SESSION['username'] = $user['username'];
     $_SESSION['role'] = $user['role'];

     header("Location: /dashboard.php");
     exit();
  } else {
  	echo "Invalid username or password.";
  }
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include '../includes/head.php' ?>
</head>
<body>
	<div class="form-container">
		<div class="form-box login-box">
			<h2>Log In</h2>
			<form method="POST" class="login-form" >
				<label for="username">Username</label>
				<input type="text" name="username" id="username" class="text-input">
				
				<label for="password">Password</label>
				<input type="password" name="password" id="password" class="text-input ">

				<button class="submit-btn" name="submit">Create</button>
			</form>	
		</div>
	</div>
</body>
</html>