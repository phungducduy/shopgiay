<?php
session_start();
include 'connect.php';

$username = trim($_POST['username']);
$password = trim($_POST['password']);
$confirm_password = trim($_POST['confirm_password']);

if ($password !== $confirm_password) {
    $_SESSION['register_error'] = "Mật khẩu không khớp!";
    header("Location: login.php");
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Kiểm tra username đã tồn tại chưa
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $_SESSION['register_error'] = "Tên đăng nhập đã tồn tại!";
    header("Location: login.php");
    exit();
}

// Thêm người dùng mới
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);
if ($stmt->execute()) {
    $_SESSION['register_success'] = "Đăng ký thành công! Bạn có thể đăng nhập.";
} else {
    $_SESSION['register_error'] = "Lỗi khi đăng ký.";
}
header("Location: login.php");
exit();
?>
