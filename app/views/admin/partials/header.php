<?php
$appConfig = require dirname(__DIR__, 3) . '/config/app.php';
Session::start();
$adminBase = $appConfig['admin_base'];
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Admin') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="admin-area">
<div class="d-flex">
    <aside class="admin-sidebar p-3 border-end">
        <h5 class="mb-4">Admin</h5>
        <ul class="nav flex-column gap-2">
            <li><a href="/<?= $adminBase ?>/dashboard" class="nav-link px-0">Dashboard</a></li>
            <li><a href="/<?= $adminBase ?>/service-types" class="nav-link px-0">Loại dịch vụ</a></li>
            <li><a href="/<?= $adminBase ?>/categories" class="nav-link px-0">Danh mục</a></li>
            <li><a href="/<?= $adminBase ?>/products" class="nav-link px-0">Sản phẩm</a></li>
            <li><a href="/<?= $adminBase ?>/options/groups" class="nav-link px-0">Option groups</a></li>
            <li><a href="/<?= $adminBase ?>/options/values" class="nav-link px-0">Option values</a></li>
            <li><a href="/<?= $adminBase ?>/variants" class="nav-link px-0">Variants</a></li>
            <li><a href="/<?= $adminBase ?>/blog" class="nav-link px-0">Blog</a></li>
            <li><a href="/<?= $adminBase ?>/reviews" class="nav-link px-0">Reviews</a></li>
            <li><a href="/<?= $adminBase ?>/banners" class="nav-link px-0">Banners</a></li>
            <li><a href="/<?= $adminBase ?>/popup" class="nav-link px-0">Popup</a></li>
            <li><a href="/<?= $adminBase ?>/footer" class="nav-link px-0">Footer</a></li>
            <li><a href="/<?= $adminBase ?>/contact-links" class="nav-link px-0">Contact links</a></li>
            <li><a href="/<?= $adminBase ?>/settings" class="nav-link px-0">Cài đặt</a></li>
        </ul>
    </aside>
    <div class="flex-grow-1">
        <header class="border-bottom p-3 d-flex justify-content-between align-items-center">
            <h1 class="h5 mb-0"><?= htmlspecialchars($title ?? '') ?></h1>
            <div>
                <span class="me-3 small text-muted"><?= htmlspecialchars(Session::get('admin_email', 'admin')) ?></span>
                <a href="/<?= $adminBase ?>/logout" class="btn btn-outline-danger btn-sm">Đăng xuất</a>
            </div>
        </header>
        <main class="p-4">

