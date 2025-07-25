<?php
session_start();
include 'db.php';
include 'includes/header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Giỏ hàng của bạn</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-warning text-center">Giỏ hàng đang trống. <a href="index.php">Mua sắm ngay</a></div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_price = 0;

                foreach ($_SESSION['cart'] as $id => $qty):
                    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $product = $result->fetch_assoc();

                    $subtotal = $product['price'] * $qty;
                    $total_price += $subtotal;
                ?>
                    <tr>
                        <td><img src="<?= $product['image'] ?>" width="80" height="80" style="object-fit:cover;"></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= number_format($product['price']) ?> VND</td>
                        <td><?= $qty ?></td>
                        <td><?= number_format($subtotal) ?> VND</td>
                        <td>
                            <a href="remove_from_cart.php?id=<?= $id ?>" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end">
            <h4>Tổng tiền: <strong><?= number_format($total_price) ?> VND</strong></h4>
            <a href="checkout.php" class="btn btn-success mt-3">Thanh toán</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
