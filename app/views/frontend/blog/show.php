<?php include dirname(__DIR__, 2) . '/partials/header.php'; ?>
<article class="mb-5">
    <h1 class="display-6 mb-3"><?= htmlspecialchars($post['title']) ?></h1>
    <p class="text-muted"><?= (new DateTime($post['published_at']))->format('d/m/Y H:i') ?></p>
    <img src="<?= htmlspecialchars($post['cover_image'] ?? '/assets/img/placeholder.jpg') ?>" class="img-fluid rounded mb-4" alt="<?= htmlspecialchars($post['title']) ?>">
    <div class="lead">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>
</article>
<?php include dirname(__DIR__, 2) . '/partials/footer.php'; ?>

