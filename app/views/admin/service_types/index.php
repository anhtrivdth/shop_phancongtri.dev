<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="row">
    <div class="col-md-6">
        <form action="/<?= $appConfig['admin_base'] ?>/service-types" method="post" class="card card-body mb-4">
            <input type="hidden" name="_csrf" value="<?= $csrf ?>">
            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" class="form-control" name="slug">
            </div>
            <div class="mb-3">
                <label class="form-label">Thứ tự</label>
                <input type="number" class="form-control" name="position" value="0">
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" checked>
                <label class="form-check-label">Kích hoạt</label>
            </div>
            <button class="btn btn-primary">Thêm loại dịch vụ</button>
        </form>
    </div>
    <div class="col-md-6">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Tên</th>
                <th>Slug</th>
                <th>Active</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['slug']) ?></td>
                    <td><?= $item['is_active'] ? 'Yes' : 'No' ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

