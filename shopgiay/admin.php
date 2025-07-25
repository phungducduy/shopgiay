<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}
include 'db.php';
include 'includes/header.php';
?>

<div class="container mt-5">
    <h2>Quản lý sản phẩm</h2>
    <a href="add_product.php" class="btn btn-success mb-3">Thêm sản phẩm</a>
    <table class="table table-bordered">
        <tr>
            <th>STT</th><th>Tên</th><th>Giá</th><th>Ảnh</th><th>Hành động</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM products");
        $stt = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$stt}</td>
                <td>{$row['name']}</td>
                <td>{$row['price']}</td>
                <td><img src='{$row['image']}' width='100'></td>
                <td>
                    <a href='edit_product.php?id={$row['id']}' class='btn btn-warning'>Sửa</a>
                    <a href='delete_product.php?id={$row['id']}' class='btn btn-danger'>Xoá</a>
                </td>
            </tr>";
            $stt++;
        }
        ?>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
