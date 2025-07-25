<?php
session_start();
include 'db.php';
include 'includes/header.php';

// Nhận các tham số lọc, tìm kiếm
$search = $_GET['search'] ?? '';
$price = $_GET['price'] ?? '';
$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

// Tạo truy vấn động
$where = "WHERE 1=1";
$params = [];
$types = "";

// Tìm kiếm theo tên
if (!empty($search)) {
    $where .= " AND name LIKE ?";
    $params[] = "%$search%";
    $types .= "s";
}

// Lọc theo khoảng giá
if ($price === '1') {
    $where .= " AND price < 500000";
} elseif ($price === '2') {
    $where .= " AND price BETWEEN 500000 AND 1000000";
} elseif ($price === '3') {
    $where .= " AND price > 1000000";
}

// Lọc theo loại giày
if (!empty($category)) {
    $where .= " AND category = ?";
    $params[] = $category;
    $types .= "s";
}

// Sắp xếp theo giá
$order = "";
if ($sort === 'asc') $order = " ORDER BY price ASC";
elseif ($sort === 'desc') $order = " ORDER BY price DESC";

// Đếm tổng số sản phẩm
$sql_count = "SELECT COUNT(*) as total FROM products $where";
$stmt_count = $conn->prepare($sql_count);
if (!empty($types)) $stmt_count->bind_param($types, ...$params);
$stmt_count->execute();
$total = $stmt_count->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

// Truy vấn danh sách sản phẩm
$sql = "SELECT * FROM products $where $order LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$params[] = $offset;
$params[] = $limit;
$types .= "ii";
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Danh sách Sneaker</h2>

    <!-- Tìm kiếm và lọc -->
    <form method="GET" class="row mb-4 g-2">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Tìm theo tên giày..." value="<?= htmlspecialchars($search); ?>">
        </div>
        <div class="col-md-2">
            <select name="price" class="form-select">
                <option value="">Khoảng giá</option>
                <option value="1" <?= $price === '1' ? 'selected' : '' ?>>Dưới 500K</option>
                <option value="2" <?= $price === '2' ? 'selected' : '' ?>>500K – 1 triệu</option>
                <option value="3" <?= $price === '3' ? 'selected' : '' ?>>Trên 1 triệu</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">Loại giày</option>
                <option value="Sneaker thấp cổ" <?= $category === 'Sneaker thấp cổ' ? 'selected' : '' ?>>Sneaker thấp cổ</option>
                <option value="Sneaker cao cổ" <?= $category === 'Sneaker cao cổ' ? 'selected' : '' ?>>Sneaker cao cổ</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="sort" class="form-select">
                <option value="">Sắp xếp</option>
                <option value="asc" <?= $sort === 'asc' ? 'selected' : '' ?>>Giá tăng</option>
                <option value="desc" <?= $sort === 'desc' ? 'selected' : '' ?>>Giá giảm</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Lọc</button>
        </div>
    </form>

    <!-- Danh sách sản phẩm -->
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?= $row['image']; ?>" class="card-img-top" style="height:300px; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['name']); ?></h5>
                        <p class="card-text text-muted" style="height: 60px; overflow: hidden;">
                            <?= htmlspecialchars($row['description']); ?>
                        </p>
                        <p class="text-danger fw-bold"><?= number_format($row['price']); ?> VND</p>
                        <a href="add_to_cart.php?id=<?= $row['id']; ?>" class="btn btn-success w-100">Thêm vào giỏ</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Phân trang -->
    <?php if ($total_pages > 1): ?>
    <nav>
        <ul class="pagination justify-content-center mt-4">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?<?php
                        $query = $_GET;
                        $query['page'] = $i;
                        echo http_build_query($query);
                    ?>">
                        <?= $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
