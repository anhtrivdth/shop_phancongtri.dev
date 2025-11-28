<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="card mb-4">
    <div class="card-body">
        <form action="/<?= $appConfig['admin_base'] ?>/products" method="post">
            <input type="hidden" name="_csrf" value="<?= $csrf ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control" name="slug">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Mô tả ngắn</label>
                    <input type="text" class="form-control" name="short_description">
                </div>
                <div class="col-12">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-md-3 form-check">
                    <input class="form-check-input" type="checkbox" name="is_visible" checked>
                    <label class="form-check-label">Hiển thị</label>
                </div>
                <div class="col-md-3 form-check">
                    <input class="form-check-input" type="checkbox" name="is_featured">
                    <label class="form-check-label">Nổi bật</label>
                </div>
                <div class="col-md-3 form-check">
                    <input class="form-check-input" type="checkbox" name="is_pinned">
                    <label class="form-check-label">Gợi ý</label>
                </div>
                <div class="col-md-3 form-check">
                    <input class="form-check-input" type="checkbox" name="review_enabled" checked>
                    <label class="form-check-label">Cho phép review</label>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary">Lưu sản phẩm</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
        <tr>
            <th>Tên</th>
            <th>Danh mục</th>
            <th>Hiển thị</th>
            <th>Nổi bật</th>
            <th>Gợi ý</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= $item['category_id'] ?></td>
                <td><?= $item['is_visible'] ? 'Yes' : 'No' ?></td>
                <td><?= $item['is_featured'] ? 'Yes' : 'No' ?></td>
                <td><?= $item['is_pinned'] ? 'Yes' : 'No' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

