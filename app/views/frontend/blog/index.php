<?php include dirname(__DIR__, 2) . '/partials/header.php'; ?>
<h1 class="h3 mb-4">Tin tức</h1>
<?php foreach ($posts as $post): ?>
    <article class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?= htmlspecialchars($post['cover_image'] ?? '/assets/img/placeholder.jpg') ?>" class="img-fluid rounded-start" alt="<?= htmlspecialchars($post['title']) ?>">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($post['excerpt'] ?? '') ?></p>
                    <p class="card-text"><small class="text-muted">
                            <?php
                            $published = new DateTime($post['published_at']);
                            echo Helper::timeAgo($published);
                            ?>
                        </small></p>
                    <a href="/tin-tuc/<?= htmlspecialchars($post['slug']) ?>" class="btn btn-outline-primary btn-sm">Xem bài viết</a>
                </div>
            </div>
        </div>
    </article>
<?php endforeach; ?>
<?php include dirname(__DIR__, 2) . '/partials/footer.php'; ?>

