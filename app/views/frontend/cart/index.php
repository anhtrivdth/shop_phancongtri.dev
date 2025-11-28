<?php include dirname(__DIR__) . '/../partials/header.php'; ?>
<h1 class="h3 mb-4">Giỏ hàng</h1>
<?php if (empty($items)): ?>
    <div class="alert alert-info">Chưa có sản phẩm trong giỏ.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>SKU</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
            </tr>
            </thead>
            <tbody>
            <?php $grand = 0; foreach ($items as $item):
                $line = ($item['price'] ?? 0) * $item['quantity'];
                $grand += $line;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['variant_id'] ?? 'N/A') ?></td>
                    <td><?= number_format($item['price'] ?? 0, 0, ',', '.') ?> ₫</td>
                    <td><?= (int)$item['quantity'] ?></td>
                    <td><?= number_format($line, 0, ',', '.') ?> ₫</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="fw-bold fs-5">Tổng cộng: <?= number_format($grand, 0, ',', '.') ?> ₫</div>
        <a href="/mua-ngay" class="btn btn-success btn-lg">Mua ngay (Liên hệ)</a>
    </div>
<?php endif; ?>
<?php include dirname(__DIR__) . '/../partials/footer.php'; ?>

