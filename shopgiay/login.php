<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Đăng nhập hệ thống</h2>
    <form action="check_login.php" method="POST">
        <div class="mb-3">
            <input type="text" name="username" placeholder="Tên đăng nhập" class="form-control" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" placeholder="Mật khẩu" class="form-control" required>
        </div>
        <button class="btn btn-primary">Đăng nhập</button>
        <a href="register.php" class="btn btn-link">Chưa có tài khoản? Đăng ký</a>
    </form>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger mt-3"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['register_success'])): ?>
        <div class="alert alert-success mt-3"><?php echo $_SESSION['register_success']; unset($_SESSION['register_success']); ?></div>
    <?php endif; ?>
</body>
</html>
