<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'db.php';
include 'includes/header.php';
?>

<div class="container mt-5">
    <h2>Thống kê đơn hàng (mô phỏng)</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Khách hàng</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
                <th>Ngày đặt</th>
            </tr>
        </thead>
        <tbody>
            <!-- Đây là dữ liệu mẫu -->
            <tr>
                <td>1</td>
                <td>Nguyễn Văn A</td>
                <td>Nike Air</td>
                <td>2</td>
                <td>3,000,000 VND</td>
                <td>2025-07-19</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Trần Thị B</td>
                <td>Adidas NMD</td>
                <td>1</td>
                <td>1,800,000 VND</td>
                <td>2025-07-18</td>
            </tr>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
