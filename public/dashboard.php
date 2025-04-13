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
<?php include '../includes/header.php'; ?>

<h2 class="products-header">Products</h2>

<div class="products-container">
	<?php 
	include '../config/db.php'; /*pdo*/
	$stmt = $pdo->query("SELECT * FROM products");
	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($products as $product):
	?> 
	<a class="product-link" href="/product.php/<?= $product['id'] ?>" id="product-<?= $product['id'] ?>" >
		<div class="product-box">
			<img src="/assets/uploads/<?= $product['image'] ? htmlspecialchars($product['image'])  : 'pi.jpg' ?>" class="product-img">

			<div>
				<div class="product-head"><h3 class="product-title"><?= htmlspecialchars($product['title']) ?> <span class="<?= $product['status'] ? 'active' : 'inactive' ?> status">(<?= $product['status'] ? 'Active' : 'Inactive' ?>)</span></h3>
					<label class="switch">
					  <input type="checkbox" class="status-checkbox" onchange="handleCheckBox(this)" <?php if ( $product['status'] ) echo 'checked'; ?> data-id=<?= $product['id'] ?> >
					  <span class="slider round"></span>
					</label>
				</div>

				<p class="product-short-description"><?= htmlspecialchars($product['short_description']) ?></p>
			</div>
		</div>
	</a>

	<?php endforeach; ?>
</div>

</body>
</html>