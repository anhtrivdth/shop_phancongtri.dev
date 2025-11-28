<?php include __DIR__ . '/../partials/header.php'; ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>SP</th>
        <th>Người dùng</th>
        <th>Rating</th>
        <th>Nội dung</th>
        <th>Ẩn</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($reviews as $item): ?>
        <tr>
            <td><?= $item['product_id'] ?></td>
            <td><?= htmlspecialchars($item['nickname'] ?? 'Ẩn danh') ?></td>
            <td><?= $item['rating'] ?></td>
            <td><?= htmlspecialchars($item['content']) ?></td>
            <td><?= $item['is_hidden'] ? 'Yes' : 'No' ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include __DIR__ . '/../partials/footer.php'; ?>

