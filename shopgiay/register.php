<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Đăng ký tài khoản</h2>
    <form action="register_process.php" method="POST">
        <div class="mb-3">
            <input type="text" name="username" placeholder="Tên đăng nhập" class="form-control" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" placeholder="Mật khẩu" class="form-control" required>
        </div>
        <div class="mb-3">
            <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu" class="form-control" required>
        </div>
        <button class="btn btn-success">Đăng ký</button>
        <a href="login.php" class="btn btn-link">Đã có tài khoản? Đăng nhập</a>
    </form>

    <?php if (isset($_SESSION['register_error'])): ?>
        <div class="alert alert-danger mt-3"><?php echo $_SESSION['register_error']; unset($_SESSION['register_error']); ?></div>
    <?php endif; ?>
</body>
</html>
