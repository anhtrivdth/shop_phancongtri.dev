<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="row">
    <div class="col-md-6">
        <form action="/<?= $appConfig['admin_base'] ?>/variants" method="post" class="card card-body mb-4">
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
                <label class="form-label">SKU</label>
                <input type="text" class="form-control" name="sku" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giá</label>
                <input type="number" class="form-control" name="price" step="0.01" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <input type="text" class="form-control" name="status_text">
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" checked>
                <label class="form-check-label">Kích hoạt</label>
            </div>
            <button class="btn btn-primary">Thêm variant</button>
        </form>
    </div>
    <div class="col-md-6">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>SKU</th>
                <th>Sản phẩm</th>
                <th>Giá</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($variants as $variant): ?>
                <tr>
                    <td><?= htmlspecialchars($variant['sku']) ?></td>
                    <td><?= $variant['product_id'] ?></td>
                    <td><?= number_format($variant['price'], 0, ',', '.') ?> ₫</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

