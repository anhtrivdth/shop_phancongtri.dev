<?php include __DIR__ . '/../partials/header.php'; ?>
<form action="/<?= $appConfig['admin_base'] ?>/banners" method="post" class="card card-body mb-4">
    <input type="hidden" name="_csrf" value="<?= $csrf ?>">
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" name="title">
        </div>
        <div class="col-md-4">
            <label class="form-label">Phụ đề</label>
            <input type="text" class="form-control" name="subtitle">
        </div>
        <div class="col-md-4">
            <label class="form-label">Ảnh</label>
            <input type="text" class="form-control" name="image_url">
        </div>
        <div class="col-md-4">
            <label class="form-label">Nhãn nút</label>
            <input type="text" class="form-control" name="button_label">
        </div>
        <div class="col-md-4">
            <label class="form-label">Link</label>
            <input type="text" class="form-control" name="button_url">
        </div>
        <div class="col-md-2">
            <label class="form-label">Thứ tự</label>
            <input type="number" class="form-control" name="position" value="0">
        </div>
        <div class="col-md-2 form-check">
            <input class="form-check-input" type="checkbox" name="is_active" checked>
            <label class="form-check-label">Kích hoạt</label>
        </div>
        <div class="col-12">
            <button class="btn btn-primary">Lưu banner</button>
        </div>
    </div>
</form>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Tiêu đề</th>
        <th>Link</th>
        <th>Active</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($banners as $banner): ?>
        <tr>
            <td><?= htmlspecialchars($banner['title']) ?></td>
            <td><?= htmlspecialchars($banner['button_url']) ?></td>
            <td><?= $banner['is_active'] ? 'Yes' : 'No' ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include __DIR__ . '/../partials/footer.php'; ?>

