<?php include dirname(__DIR__) . '/../partials/header.php'; ?>
<div class="row">
    <aside class="col-md-3">
        <div class="border rounded p-3 mb-4">
            <h5 class="mb-3">Loại dịch vụ</h5>
            <ul class="list-unstyled">
                <?php foreach ($serviceTypes as $type): ?>
                    <li class="mb-2">
                        <a href="/san-pham?service=<?= $type['id'] ?>" class="text-decoration-none"><?= htmlspecialchars($type['name']) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </aside>
    <section class="col-md-9">
        <form class="row g-2 mb-4">
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>" placeholder="Tìm sản phẩm">
            </div>
            <div class="col-md-4">
                <select name="sort" class="form-select">
                    <option value="newest" <?= ($filters['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                    <option value="price_asc" <?= ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                    <option value="price_desc" <?= ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                    <option value="popular" <?= ($filters['sort'] ?? '') === 'popular' ? 'selected' : '' ?>>Phổ biến</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Lọc</button>
            </div>
        </form>

        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <span class="badge bg-success mb-2"><?= htmlspecialchars($product['category_name']) ?></span>
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="text-muted small"><?= htmlspecialchars($product['short_description'] ?? '') ?></p>
                            <p class="fw-semibold"><?= number_format($product['min_price'], 0, ',', '.') ?> - <?= number_format($product['max_price'], 0, ',', '.') ?> ₫</p>
                            <a href="/san-pham/<?= htmlspecialchars($product['slug']) ?>" class="btn btn-outline-primary w-100">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>
<?php include dirname(__DIR__) . '/../partials/footer.php'; ?>

