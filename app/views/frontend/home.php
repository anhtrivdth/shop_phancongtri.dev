<?php include dirname(__DIR__) . '/../partials/header.php'; ?>
<section class="mb-4">
    <div class="p-5 bg-gradient rounded-4 text-white text-center shadow">
        <h1 class="display-5 fw-bold mb-3">Khám phá tài khoản số chất lượng</h1>
        <p class="mb-4">Chọn biến thể phù hợp, thêm vào giỏ và liên hệ admin để hoàn tất.</p>
        <form action="/san-pham" method="get" class="row g-2 justify-content-center">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control form-control-lg" placeholder="Tìm kiếm dịch vụ theo tên hoặc slug">
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark btn-lg w-100">Tìm kiếm</button>
            </div>
        </form>
    </div>
</section>

<?php if (!empty($featured)): ?>
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Sản phẩm nổi bật</h2>
            <a href="/san-pham" class="text-decoration-none">Xem tất cả</a>
        </div>
        <div class="row g-4">
            <?php foreach ($featured as $item): ?>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($item['short_description'] ?? '') ?></p>
                            <p class="fw-bold text-primary"><?= number_format($item['min_price'], 0, ',', '.') ?> - <?= number_format($item['max_price'], 0, ',', '.') ?> ₫</p>
                            <a href="/san-pham/<?= htmlspecialchars($item['slug']) ?>" class="btn btn-outline-primary w-100">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<?php if (!empty($recommended)): ?>
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Sản phẩm gợi ý</h2>
        </div>
        <div class="row g-4">
            <?php foreach ($recommended as $item): ?>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                            <p class="text-muted small"><?= htmlspecialchars($item['status_text'] ?? '') ?></p>
                            <a href="/san-pham/<?= htmlspecialchars($item['slug']) ?>" class="btn btn-primary w-100">Mua ngay</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<?php if (!empty($blogPosts)): ?>
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Tin tức mới nhất</h2>
            <a href="/tin-tuc" class="text-decoration-none">Xem thêm</a>
        </div>
        <?php foreach ($blogPosts as $post): ?>
            <article class="card mb-3 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= htmlspecialchars($post['cover_image'] ?? '/assets/img/placeholder.jpg') ?>" class="img-fluid rounded-start" alt="<?= htmlspecialchars($post['title']) ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($post['excerpt'] ?? '') ?></p>
                            <a href="/tin-tuc/<?= htmlspecialchars($post['slug']) ?>" class="btn btn-outline-secondary btn-sm">Đọc tiếp</a>
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

<?php if (!empty($contactLinks)): ?>
    <section class="mb-5 text-center">
        <h2 class="h4 mb-3">Liên hệ nhanh</h2>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <?php foreach ($contactLinks as $link): ?>
                <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" class="btn btn-outline-dark">
                    <?= ucfirst($link['type']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<?php if (!empty($popup)): ?>
    <div id="promoPopup" class="promo-popup card shadow-lg p-4" data-delay="1800" data-ttl="1800">
        <button class="btn-close float-end" data-close></button>
        <img src="<?= htmlspecialchars($popup['image_url'] ?? '/assets/img/placeholder.jpg') ?>" class="img-fluid rounded mb-3" alt="Promo">
        <h5><?= htmlspecialchars($popup['title']) ?></h5>
        <p><?= htmlspecialchars($popup['body']) ?></p>
        <a href="<?= htmlspecialchars($popup['action_url']) ?>" class="btn btn-primary"><?= htmlspecialchars($popup['action_label']) ?></a>
    </div>
<?php endif; ?>

<?php include dirname(__DIR__) . '/../partials/footer.php'; ?>

