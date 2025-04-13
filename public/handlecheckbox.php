<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit;
}

include 'config/db.php'; /*pdo*/
header('Content-type: application/json; charset=UTF-8');


if (isset($_POST['id'], $_POST['checked'])) {
    $id = $_POST['id'];
    $checked = $_POST['checked'] ? 'true' : 'false' ;

    $sql_product = "SELECT count(*) FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql_product);
    $stmt->execute([$id]);
    $exists = $stmt->fetchColumn();

    if ($exists) {
        $sql_update = "UPDATE products SET status = ? where id = ?";
        $update = $pdo->prepare($sql_update);
        $update->execute([$checked, $id]);

        echo json_encode([
            'success' => true,
            'message' => "Item $id " . ($checked ? 'selected' : 'unselected')
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "Item $id update failed"
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
}
?>
