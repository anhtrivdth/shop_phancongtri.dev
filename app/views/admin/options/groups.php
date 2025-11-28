<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="row">
    <div class="col-md-6">
        <form action="/<?= $appConfig['admin_base'] ?>/options/groups" method="post" class="card card-body mb-4">
            <input type="hidden" name="_csrf" value="<?= $csrf ?>">
            <div class="mb-3">
                <label class="form-label">Sản phẩm</label>
                <select name="product_id" class="form-select">
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['id'] ?>"><?= htmlspecialchars($product['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tên nhóm</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Hiển thị</label>
                <select class="form-select" name="display_type">
                    <option value="buttons">Button</option>
                    <option value="dropdown">Dropdown</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Thứ tự</label>
                <input type="number" class="form-control" name="position" value="0">
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="required" checked>
                <label class="form-check-label">Bắt buộc</label>
            </div>
            <button class="btn btn-primary">Thêm nhóm</button>
        </form>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Tên nhóm</th>
                <th>Hiển thị</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?= $group['product_id'] ?></td>
                    <td><?= htmlspecialchars($group['name']) ?></td>
                    <td><?= htmlspecialchars($group['display_type']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

