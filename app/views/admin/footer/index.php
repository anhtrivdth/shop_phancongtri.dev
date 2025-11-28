<?php include __DIR__ . '/../partials/header.php'; ?>
<form action="/<?= $appConfig['admin_base'] ?>/footer" method="post" class="card card-body">
    <input type="hidden" name="_csrf" value="<?= $csrf ?>">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Logo URL</label>
            <input type="text" class="form-control" name="logo_url" value="<?= htmlspecialchars($footer['logo_url'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">QR Code URL</label>
            <input type="text" class="form-control" name="qr_code_url" value="<?= htmlspecialchars($footer['qr_code_url'] ?? '') ?>">
        </div>
        <div class="col-12">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($footer['description'] ?? '') ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Mini banner</label>
            <input type="text" class="form-control" name="mini_banner_url" value="<?= htmlspecialchars($footer['mini_banner_url'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Copyright</label>
            <input type="text" class="form-control" name="copyright_text" value="<?= htmlspecialchars($footer['copyright_text'] ?? '') ?>">
        </div>
        <div class="col-12">
            <label class="form-label">Policies (JSON)</label>
            <textarea name="policies" class="form-control" rows="2"><?= htmlspecialchars(json_encode($footer['policies'] ?? [], JSON_PRETTY_PRINT)) ?></textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Quick links (JSON)</label>
            <textarea name="quick_links" class="form-control" rows="2"><?= htmlspecialchars(json_encode($footer['quick_links'] ?? [], JSON_PRETTY_PRINT)) ?></textarea>
        </div>
        <div class="col-12">
            <button class="btn btn-primary">Lưu footer</button>
        </div>
    </div>
</form>
<?php include __DIR__ . '/../partials/footer.php'; ?>

