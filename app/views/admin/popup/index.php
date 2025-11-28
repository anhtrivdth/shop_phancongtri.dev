<?php include __DIR__ . '/../partials/header.php'; ?>
<form action="/<?= $appConfig['admin_base'] ?>/popup" method="post" class="card card-body">
    <input type="hidden" name="_csrf" value="<?= $csrf ?>">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($popup['title'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Ảnh</label>
            <input type="text" class="form-control" name="image_url" value="<?= htmlspecialchars($popup['image_url'] ?? '') ?>">
        </div>
        <div class="col-12">
            <label class="form-label">Nội dung</label>
            <textarea name="body" class="form-control" rows="3"><?= htmlspecialchars($popup['body'] ?? '') ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Label nút</label>
            <input type="text" class="form-control" name="action_label" value="<?= htmlspecialchars($popup['action_label'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">URL nút</label>
            <input type="text" class="form-control" name="action_url" value="<?= htmlspecialchars($popup['action_url'] ?? '') ?>">
        </div>
        <div class="col-12 form-check">
            <input class="form-check-input" type="checkbox" name="is_enabled" <?= !empty($popup['is_enabled']) ? 'checked' : '' ?>>
            <label class="form-check-label">Kích hoạt popup</label>
        </div>
        <div class="col-12">
            <button class="btn btn-primary">Lưu popup</button>
        </div>
    </div>
</form>
<?php include __DIR__ . '/../partials/footer.php'; ?>

