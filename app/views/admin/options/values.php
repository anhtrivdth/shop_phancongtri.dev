<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="row">
    <div class="col-md-6">
        <form action="/<?= $appConfig['admin_base'] ?>/options/values" method="post" class="card card-body mb-4">
            <input type="hidden" name="_csrf" value="<?= $csrf ?>">
            <div class="mb-3">
                <label class="form-label">Nhóm</label>
                <select name="group_id" class="form-select">
                    <?php foreach ($groups as $group): ?>
                        <option value="<?= $group['id'] ?>"><?= htmlspecialchars($group['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Giá trị</label>
                <input type="text" class="form-control" name="value" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Thứ tự</label>
                <input type="number" class="form-control" name="position" value="0">
            </div>
            <button class="btn btn-primary">Thêm giá trị</button>
        </form>
    </div>
    <div class="col-md-6">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Nhóm</th>
                <th>Giá trị</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($values as $value): ?>
                <tr>
                    <td><?= $value['group_id'] ?></td>
                    <td><?= htmlspecialchars($value['value']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

