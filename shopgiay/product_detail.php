<?php
session_start();
include 'db.php';
include 'includes/header.php';

// Kiểm tra có ID sản phẩm không
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container mt-5 text-center'><h4>Không tìm thấy sản phẩm</h4></div>";
    include 'includes/footer.php';
    exit();
}

$id = (int)$_GET['id'];

// Lấy thông tin sản phẩm
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<div class='container mt-5 text-center'><h4>Sản phẩm không tồn tại</h4></div>";
    include 'includes/footer.php';
    exit();
}

$product = $result->fetch_assoc();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>
        <div class="col-md-6">
            <h2 class="mb-3"><?= htmlspecialchars($product['name']) ?></h2>
            <p class="text-danger fs-4 fw-bold"><?= number_format($product['price']) ?> VND</p>
            <p><strong>Loại sản phẩm:</strong> <?= htmlspecialchars($product['category']) ?></p>
            <hr>
            <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

            <a href="add_to_cart.php?id=<?= $product['id'] ?>" class="btn btn-success btn-lg mt-3">Thêm vào giỏ hàng</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
