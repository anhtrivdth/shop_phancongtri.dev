<?php
$appConfig = require dirname(__DIR__, 2) . '/config/app.php';
Session::start();
$cartItems = Session::get('cart_items_count', 0);
?>
<!doctype html>
<html lang="vi" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Shop Accounts') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<header class="py-3 border-bottom">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
        <a href="/" class="fs-4 fw-bold text-decoration-none text-primary">Shop Accounts</a>
        <div class="d-flex gap-3 align-items-center">
            <button id="themeToggle" class="btn btn-outline-secondary btn-sm">Toggle theme</button>
            <a href="/gio-hang" class="btn btn-primary position-relative">
                Giỏ hàng
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
                    <?= (int)$cartItems ?>
                </span>
            </a>
        </div>
    </div>
</header>
<nav class="py-2 bg-light border-bottom">
    <div class="container d-flex gap-3">
        <a href="/" class="text-decoration-none">Trang chủ</a>
        <a href="/san-pham" class="text-decoration-none">Sản phẩm</a>
        <a href="/gio-hang" class="text-decoration-none">Giỏ hàng</a>
        <a href="/tin-tuc" class="text-decoration-none">Tin tức</a>
        <a href="/lien-he" class="text-decoration-none">Liên hệ</a>
    </div>
</nav>
<main class="py-4">
    <div class="container">

