<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Shop Giày</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Sneaker Shop</a>
        <div class="ms-auto">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="text-white me-2">Xin chào, <?= $_SESSION['user'] ?></span>
                <a href="cart.php" class="btn btn-outline-light me-2">Giỏ hàng</a>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a href="admin.php" class="btn btn-warning me-2">Quản trị</a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-light">Đăng nhập</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
