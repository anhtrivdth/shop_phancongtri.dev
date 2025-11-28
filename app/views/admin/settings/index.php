<?php include __DIR__ . '/../partials/header.php'; ?>
<form action="/<?= $appConfig['admin_base'] ?>/settings" method="post" class="card card-body">
    <input type="hidden" name="_csrf" value="<?= $csrf ?>">
    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" name="dark_mode_default" <?= !empty($setting['dark_mode_default']) ? 'checked' : '' ?>>
        <label class="form-check-label">Dark mode mặc định</label>
    </div>
    <div class="mb-3">
        <label class="form-label">Placeholder tìm kiếm</label>
        <input type="text" class="form-control" name="hero_search_placeholder" value="<?= htmlspecialchars($setting['hero_search_placeholder'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Admin base path</label>
        <input type="text" class="form-control" name="admin_base_path" value="<?= htmlspecialchars($setting['admin_base_path'] ?? $appConfig['admin_base']) ?>">
    </div>
    <button class="btn btn-primary">Lưu cài đặt</button>
</form>
<?php include __DIR__ . '/../partials/footer.php'; ?>

