<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Upload ảnh
    $target_dir = "images/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $sql = "INSERT INTO products (name, price, image, description) 
            VALUES ('$name', '$price', '$target_file', '$description')";
    $conn->query($sql);

    header("Location: admin.php");
}
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>Thêm sản phẩm</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Giá</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ảnh sản phẩm</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label>Mô tả sản phẩm</label>
            <textarea name="description" class="form-control" rows="5" placeholder="Nhập mô tả chi tiết..."></textarea>
        </div>
        <button class="btn btn-success">Thêm</button>
        <a href="admin.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
