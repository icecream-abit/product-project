<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: /login.php");
	exit;
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
<?php 
	include '../includes/header.php'; 

	$requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	$productId = null;
	if (preg_match("#^/product.php/(\d+)$#", $requestUri, $matches)) {
	    $productId = htmlspecialchars($matches[1]);
	 }
	 include '../config/db.php'; /*pdo*/
	 $sql_product = "SELECT * FROM products WHERE id = ? LIMIT 1";
	 $stmt = $pdo->prepare($sql_product);
	 $stmt->execute([$productId]);
	 $product = $stmt->fetch(PDO::FETCH_ASSOC);

	 if ($product):
?>
	<main class="product-main">
		<div class="product-container">
			<h1><?= $product['title'] ?> - <span class="<?= $product['status'] ? 'active' : 'inactive' ?> status">(<?= $product['status'] ? 'Active' : 'Inactive' ?>)</span></h1>
			<p><?= $product['short_description'] ?></p>

			<img src="/assets/uploads/<?= $product['image'] ?>">

			<p><?= $product['long_description'] ?></p>
		</div>
	</main>

<?php endif ?>
</body>
</html>