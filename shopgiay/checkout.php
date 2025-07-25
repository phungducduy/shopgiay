<?php
session_start();
include 'connect.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Bạn cần đăng nhập để thanh toán.";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<div class='alert alert-warning'>Giỏ hàng trống! <a href='index.php'>Quay lại mua hàng</a></div>";
    exit();
}

// Thời gian hiện tại
$order_time = date("Y-m-d H:i:s");

// Tạo đơn hàng
$stmt = $conn->prepare("INSERT INTO orders (user_id, created_at) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $order_time);
$stmt->execute();
$order_id = $conn->insert_id;

// Thêm các sản phẩm vào order_items
$stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach ($cart as $item) {
    if (is_array($item) && isset($item['id'], $item['quantity'], $item['price'])) {
        $product_id = $item['id'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        $stmt->execute();
    }
}

// Xoá giỏ hàng sau khi đặt hàng
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thanh toán thành công</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="alert alert-success">
        ✅ Đặt hàng thành công!<br>
        <strong>Mã đơn hàng:</strong> #<?php echo $order_id; ?><br>
        <strong>Thời gian:</strong> <?php echo $order_time; ?>
    </div>
    <a href="index.php" class="btn btn-primary">Tiếp tục mua hàng</a>
</body>
</html>
