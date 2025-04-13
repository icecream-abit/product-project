<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: /login.php");
	exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	include '../config/db.php'; /*pdo*/

	function check_uploaded_image()
	{
		$targetDir = "assets/uploads/";
		$fileTmpPath = $_FILES['image']['tmp_name'];
		$imageExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
		$newFileName = time() . '.' . $imageExtension;

		if (isset($_POST['submit'])) {
			$check = getimagesize($fileTmpPath);
			if ($check == false) {
				return 0;
			}	
		}

		$allowedTypes = ["jpg", "jpeg", "png", "webp"];
		if (!in_array($imageExtension, $allowedTypes)) {
			echo $imageExtension;
		   echo "Sorry, only JPG, JPEG, PNG & webp files are allowed.<br>";
		   return 0;
		}

		$destPath = $targetDir . $newFileName;
		if (move_uploaded_file($fileTmpPath, $destPath)) {
		   echo "File uploaded successfully as $newFileName";
		   return $newFileName;
		} else {
		   echo "There was an error uploading the file.";
		   return 0;
		}

	}

	$title = $_POST['title'];
	$short_description = $_POST['short_description'];
	$long_description = $_POST['long_description'];
	$new_image_name = check_uploaded_image();
	if ($new_image_name) {
		$sql = "INSERT INTO products (title, short_description, long_description, image) VALUES (?, ?, ?, ?)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$title, $short_description, $long_description, $new_image_name]);
	}

	$pdo = null; 
	exit();

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

	<?php include '../includes/header.php'; ?>

	<div class="form-container">
	<div class="form-box">	
		<h2 class="form-heading">Add Product</h2>

		<form method="POST" enctype="multipart/form-data" class="product-form" >
			<label for="title">Title</label>
			<input type="text" name="title" id="title" class="text-input">

			<label for="short_description">Short Description</label>
			<textarea name="short_description" id="short_description" class="text-input"></textarea>

			<label for="long_description">Long Description</label>
			<textarea name="long_description" id="long_description" class="text-input"></textarea>

			<label for="image" class="file-upload-label">
				<span id="image-selector-text">Select Image</span>
				<input type="file" name="image" id="image" onchange="readURL(this)">
				<img src="#" id="view" width="200px">
			</label>
			

			<button class="submit-btn" name="submit">Create</button>
		</form>
	</div>
	</div>
</body>
</html>