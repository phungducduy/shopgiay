<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'db.php';

$id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    if ($_FILES['image']['name']) {
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = "images/" . $image_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $target_file = $product['image'];
    }

    $sql = "UPDATE products SET name='$name', price='$price', image='$target_file' WHERE id=$id";
    $conn->query($sql);
    header("Location: admin.php");
}
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>Chỉnh sửa sản phẩm</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Tên sản phẩm</label>
            <input type="text" name="name" value="<?= $product['name'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Giá</label>
            <input type="number" name="price" value="<?= $product['price'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ảnh mới (nếu muốn đổi)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <img src="<?= $product['image'] ?>" width="150" class="mt-2">
        </div>
        <button class="btn btn-primary">Cập nhật</button>
        <a href="admin.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
