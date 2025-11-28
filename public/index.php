<?php

require_once dirname(__DIR__) . '/core/Autoloader.php';
Autoloader::register();
Session::start();

$appConfig = require dirname(__DIR__) . '/config/app.php';
$siteSetting = (new SiteSetting())->current();
$adminBase = $siteSetting['admin_base_path'] ?? $appConfig['admin_base'];

if ($appConfig['debug']) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

$router = new Router('/');

// Frontend routes
$router->add('GET', '/', [new HomeController(), 'index']);
$router->add('GET', '/san-pham', [new ProductController(), 'index']);
$router->add('GET', '/san-pham/{slug}', function ($slug) {
    return (new ProductController())->show($slug);
});
$router->add('GET', '/gio-hang', [new CartController(), 'index']);
$router->add('POST', '/cart/add', [new CartController(), 'add']);
$router->add('GET', '/mua-ngay', [new CartController(), 'redirectToContact']);
$router->add('GET', '/tin-tuc', [new BlogController(), 'index']);
$router->add('GET', '/tin-tuc/{slug}', function ($slug) {
    return (new BlogController())->show($slug);
});
$router->add('GET', '/lien-he', [new ContactController(), 'index']);
$router->add('POST', '/reviews', [new ReviewController(), 'store']);
$router->add('POST', '/variants/price', [new VariantController(), 'price']);

// Admin auth routes
$router->add('GET', '/' . $adminBase . '/login', [new AdminAuthController(), 'showLogin']);
$router->add('POST', '/' . $adminBase . '/login', function () {
    $controller = new AdminAuthController();
    $action = $_POST['action'] ?? 'otp';
    if ($action === 'verify') {
        $controller->verifyOtp();
    } else {
        $controller->requestOtp();
    }
});
$router->add('GET', '/' . $adminBase . '/logout', [new AdminAuthController(), 'logout']);

// Admin secured routes
$router->add('GET', '/' . $adminBase . '/dashboard', [new AdminDashboardController(), 'index']);
$router->add('GET', '/' . $adminBase . '/service-types', [new AdminServiceTypeController(), 'index']);
$router->add('POST', '/' . $adminBase . '/service-types', [new AdminServiceTypeController(), 'store']);
$router->add('GET', '/' . $adminBase . '/categories', [new AdminCategoryController(), 'index']);
$router->add('POST', '/' . $adminBase . '/categories', [new AdminCategoryController(), 'store']);
$router->add('GET', '/' . $adminBase . '/products', [new AdminProductController(), 'index']);
$router->add('POST', '/' . $adminBase . '/products', [new AdminProductController(), 'store']);
$router->add('GET', '/' . $adminBase . '/options/groups', [new AdminOptionController(), 'groups']);
$router->add('POST', '/' . $adminBase . '/options/groups', [new AdminOptionController(), 'storeGroup']);
$router->add('GET', '/' . $adminBase . '/options/values', [new AdminOptionController(), 'values']);
$router->add('POST', '/' . $adminBase . '/options/values', [new AdminOptionController(), 'storeValue']);
$router->add('GET', '/' . $adminBase . '/variants', [new AdminVariantController(), 'index']);
$router->add('POST', '/' . $adminBase . '/variants', [new AdminVariantController(), 'store']);
$router->add('GET', '/' . $adminBase . '/reviews', [new AdminReviewController(), 'index']);
$router->add('GET', '/' . $adminBase . '/blog', [new AdminBlogController(), 'index']);
$router->add('POST', '/' . $adminBase . '/blog', [new AdminBlogController(), 'store']);
$router->add('GET', '/' . $adminBase . '/banners', [new AdminBannerController(), 'index']);
$router->add('POST', '/' . $adminBase . '/banners', [new AdminBannerController(), 'store']);
$router->add('GET', '/' . $adminBase . '/popup', [new AdminPopupController(), 'index']);
$router->add('POST', '/' . $adminBase . '/popup', [new AdminPopupController(), 'store']);
$router->add('GET', '/' . $adminBase . '/footer', [new AdminFooterController(), 'index']);
$router->add('POST', '/' . $adminBase . '/footer', [new AdminFooterController(), 'store']);
$router->add('GET', '/' . $adminBase . '/contact-links', [new AdminContactController(), 'index']);
$router->add('POST', '/' . $adminBase . '/contact-links', [new AdminContactController(), 'store']);
$router->add('GET', '/' . $adminBase . '/settings', [new AdminSettingController(), 'index']);
$router->add('POST', '/' . $adminBase . '/settings', [new AdminSettingController(), 'store']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

