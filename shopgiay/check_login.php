<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Kiểm tra mật khẩu đã hash
    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id']; // Thêm dòng này để phục vụ checkout

        // Nếu có lưu trang trước đó (checkout), quay lại checkout
        if (isset($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirect");
        } else {
            header("Location: index.php");
        }
        exit;
    }
}

// Sai tài khoản
$_SESSION['error'] = "Sai tài khoản hoặc mật khẩu!";
header("Location: login.php");
exit;
?>
