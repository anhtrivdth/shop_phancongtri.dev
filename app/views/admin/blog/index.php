<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="card mb-4">
    <div class="card-body">
        <form action="/<?= $appConfig['admin_base'] ?>/blog" method="post">
            <input type="hidden" name="_csrf" value="<?= $csrf ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control" name="slug">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ảnh cover</label>
                    <input type="text" class="form-control" name="cover_image">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ngày đăng</label>
                    <input type="datetime-local" class="form-control" name="published_at">
                </div>
                <div class="col-12">
                    <label class="form-label">Tóm tắt</label>
                    <textarea class="form-control" name="excerpt" rows="2"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Nội dung</label>
                    <textarea class="form-control" name="content" rows="4"></textarea>
                </div>
                <div class="col-12 form-check">
                    <input class="form-check-input" type="checkbox" name="is_visible" checked>
                    <label class="form-check-label">Hiển thị</label>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary">Lưu bài viết</button>
                </div>
            </div>
        </form>
    </div>
</div>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Tiêu đề</th>
        <th>Slug</th>
        <th>Hiển thị</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($posts as $post): ?>
        <tr>
            <td><?= htmlspecialchars($post['title']) ?></td>
            <td><?= htmlspecialchars($post['slug']) ?></td>
            <td><?= $post['is_visible'] ? 'Yes' : 'No' ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include __DIR__ . '/../partials/footer.php'; ?>

