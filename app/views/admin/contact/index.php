<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="row">
    <div class="col-md-6">
        <form action="/<?= $appConfig['admin_base'] ?>/contact-links" method="post" class="card card-body mb-4">
            <input type="hidden" name="_csrf" value="<?= $csrf ?>">
            <div class="mb-3">
                <label class="form-label">Kênh</label>
                <select name="type" class="form-select">
                    <option value="messenger">Messenger</option>
                    <option value="zalo">Zalo</option>
                    <option value="telegram">Telegram</option>
                    <option value="whatsapp">WhatsApp</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">URL</label>
                <input type="url" class="form-control" name="url" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Thứ tự</label>
                <input type="number" class="form-control" name="position" value="0">
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" checked>
                <label class="form-check-label">Hiển thị</label>
            </div>
            <button class="btn btn-primary">Thêm link</button>
        </form>
    </div>
    <div class="col-md-6">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Kênh</th>
                <th>URL</th>
                <th>Active</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($links as $link): ?>
                <tr>
                    <td><?= htmlspecialchars($link['type']) ?></td>
                    <td><?= htmlspecialchars($link['url']) ?></td>
                    <td><?= $link['is_active'] ? 'Yes' : 'No' ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

