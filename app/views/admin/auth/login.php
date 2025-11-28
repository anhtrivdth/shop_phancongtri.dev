<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-3 text-center">OTP Login</h1>
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>
                    <form action="" method="post" class="mb-4" autocomplete="off">
                        <input type="hidden" name="_csrf" value="<?= $csrf ?>">
                        <div class="mb-3">
                            <label class="form-label">Email admin</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <button class="btn btn-primary w-100" name="action" value="otp">Nhận OTP</button>
                    </form>
                    <form action="" method="post" autocomplete="off">
                        <input type="hidden" name="_csrf" value="<?= $csrf ?>">
                        <div class="mb-3">
                            <label class="form-label">Mã OTP</label>
                            <input type="text" class="form-control" name="otp" maxlength="6">
                        </div>
                        <button class="btn btn-success w-100" name="action" value="verify">Đăng nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

