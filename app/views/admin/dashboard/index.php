<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Sản phẩm</p>
                <h3><?= $productCount ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Đánh giá</p>
                <h3><?= $reviewCount ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Bài viết</p>
                <h3><?= $blogCount ?></h3>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

