<?php include dirname(__DIR__) . '/../partials/header.php'; ?>
<div class="row">
    <div class="col-md-6">
        <div id="productCarousel" class="carousel slide mb-4">
            <div class="carousel-inner rounded shadow">
                <?php foreach ($media as $index => $item): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= htmlspecialchars($item['image_url']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($item['alt_text'] ?? $product['name']) ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
    <div class="col-md-6">
        <h1 class="h3 mb-3"><?= htmlspecialchars($product['name']) ?></h1>
        <p class="text-muted"><?= htmlspecialchars($product['status_text'] ?? '') ?></p>
        <div class="mb-3">
            <span class="text-muted">Giá tham khảo:</span>
            <div class="fs-4 fw-bold" id="priceDisplay">
                <?= number_format($product['min_price'], 0, ',', '.') ?> - <?= number_format($product['max_price'], 0, ',', '.') ?> ₫
            </div>
        </div>
        <form action="/cart/add" method="post" class="product-options" data-product="<?= $product['id'] ?>">
            <input type="hidden" name="_csrf" value="<?= $csrf ?>">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <input type="hidden" name="variant_id" id="variantIdField">
            <?php foreach ($groups as $group): ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><?= htmlspecialchars($group['name']) ?></label>
                    <?php if ($group['display_type'] === 'dropdown' && count($group['values']) > 5): ?>
                        <select class="form-select option-input" data-group="<?= $group['id'] ?>">
                            <option value="">Chọn...</option>
                            <?php foreach ($group['values'] as $value): ?>
                                <option value="<?= $value['id'] ?>"><?= htmlspecialchars($value['value']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <div class="btn-group flex-wrap d-flex gap-2" role="group">
                            <?php foreach ($group['values'] as $value): ?>
                                <button type="button" class="btn btn-outline-secondary option-btn" data-value="<?= $value['id'] ?>" data-group="<?= $group['id'] ?>">
                                    <?= htmlspecialchars($value['value']) ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <div class="d-flex gap-3 mt-4">
                <button class="btn btn-primary flex-fill">Thêm vào giỏ</button>
                <a href="/mua-ngay" class="btn btn-outline-dark flex-fill">Mua ngay</a>
            </div>
        </form>
    </div>
</div>

<section class="mt-5">
    <h2 class="h5 mb-3">Mô tả sản phẩm</h2>
    <div class="card card-body">
        <?= nl2br(htmlspecialchars($product['description'] ?? '')) ?>
    </div>
</section>

<section class="mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Đánh giá</h2>
    </div>
    <div class="row">
        <div class="col-md-6">
            <form action="/reviews" method="post" class="card card-body">
                <input type="hidden" name="_csrf" value="<?= $csrf ?>">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div class="mb-3">
                    <label class="form-label">Tên hiển thị</label>
                    <input type="text" class="form-control" name="nickname" placeholder="Ẩn danh">
                </div>
                <div class="mb-3">
                    <label class="form-label">Đánh giá</label>
                    <select name="rating" class="form-select">
                        <option value="">Không đánh giá</option>
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <option value="<?= $i ?>"><?= $i ?> sao</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nội dung</label>
                    <textarea class="form-control" name="content" rows="4" required></textarea>
                </div>
                <button class="btn btn-primary">Gửi đánh giá</button>
            </form>
        </div>
        <div class="col-md-6">
            <?php foreach ($reviews as $item): ?>
                <div class="border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <strong><?= htmlspecialchars($item['nickname'] ?? 'Ẩn danh') ?></strong>
                        <span class="badge bg-warning text-dark"><?= $item['rating'] ?: 'N/A' ?>★</span>
                    </div>
                    <p class="mb-0"><?= htmlspecialchars($item['content']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/../partials/footer.php'; ?>

