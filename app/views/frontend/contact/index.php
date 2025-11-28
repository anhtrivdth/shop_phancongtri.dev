<?php include dirname(__DIR__) . '/../partials/header.php'; ?>
<div class="text-center py-5">
    <h1 class="h3 mb-4">Liên hệ với chúng tôi</h1>
    <p class="mb-4 text-muted">Chọn một kênh bên dưới để liên hệ admin. Không có form trên trang web.</p>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
        <?php foreach ($links as $link): ?>
            <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" class="btn btn-lg btn-outline-primary">
                <?= ucfirst($link['type']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php include dirname(__DIR__) . '/../partials/footer.php'; ?>

