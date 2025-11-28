<?php
declare(strict_types=1);

session_start();

use Core\Database;
use Controllers\Backend\AdminContactsController;
use Controllers\Backend\AdminsController;
use Controllers\Backend\AuthController as BackendAuthController;
use Controllers\Backend\BlogCategoriesController;
use Controllers\Backend\BlogsController as BackendBlogsController;
use Controllers\Backend\CategoriesLvl1Controller;
use Controllers\Backend\CategoriesLvl2Controller;
use Controllers\Backend\CsvController;
use Controllers\Backend\DashboardController;
use Controllers\Backend\ProductImagesController;
use Controllers\Backend\ProductOptionsController;
use Controllers\Backend\ProductsController as BackendProductsController;
use Controllers\Frontend\BlogController;
use Controllers\Frontend\CategoryController;
use Controllers\Frontend\HomeController;
use Controllers\Frontend\ProductController;
use Core\Router;
use Models\Admin;

require_once dirname(__DIR__) . '/core/Functions.php';

spl_autoload_register(function (string $class): void {
    $baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR;
    $prefixes = [
        'Core\\'        => 'core/',
        'Controllers\\' => 'controllers/',
        'Models\\'      => 'models/',
    ];

    foreach ($prefixes as $prefix => $directory) {
        if (str_starts_with($class, $prefix)) {
            $relative = substr($class, strlen($prefix));
            $file = $baseDir . $directory . str_replace('\\', '/', $relative) . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
            return;
        }
    }
});

$pdo = Database::getConnection();
(new Admin($pdo))->ensureDefaultAdmin();

$router = new Router($pdo);

// Frontend
$router->get('/', HomeController::class . '@index');
$router->get('/home', HomeController::class . '@index');
$router->get('/category', CategoryController::class . '@show');
$router->get('/product', ProductController::class . '@show');
$router->get('/blog', BlogController::class . '@index');
$router->get('/blog/post', BlogController::class . '@detail');

// Admin auth
$router->get('/admin/login', BackendAuthController::class . '@index');
$router->post('/admin/login', BackendAuthController::class . '@login');
$router->get('/admin/logout', BackendAuthController::class . '@logout');

// Admin dashboard
$router->get('/admin/dashboard', DashboardController::class . '@index');

// Level 1 categories
$router->get('/admin/categories', CategoriesLvl1Controller::class . '@index');
$router->get('/admin/categories/create', CategoriesLvl1Controller::class . '@create');
$router->post('/admin/categories/store', CategoriesLvl1Controller::class . '@store');
$router->get('/admin/categories/edit', CategoriesLvl1Controller::class . '@edit');
$router->post('/admin/categories/update', CategoriesLvl1Controller::class . '@update');
$router->post('/admin/categories/delete', CategoriesLvl1Controller::class . '@delete');

// Level 2 categories
$router->get('/admin/categories/lvl2', CategoriesLvl2Controller::class . '@index');
$router->get('/admin/categories/lvl2/create', CategoriesLvl2Controller::class . '@create');
$router->post('/admin/categories/lvl2/store', CategoriesLvl2Controller::class . '@store');
$router->get('/admin/categories/lvl2/edit', CategoriesLvl2Controller::class . '@edit');
$router->post('/admin/categories/lvl2/update', CategoriesLvl2Controller::class . '@update');
$router->post('/admin/categories/lvl2/delete', CategoriesLvl2Controller::class . '@delete');

// Products
$router->get('/admin/products', BackendProductsController::class . '@index');
$router->get('/admin/products/create', BackendProductsController::class . '@create');
$router->post('/admin/products/store', BackendProductsController::class . '@store');
$router->get('/admin/products/edit', BackendProductsController::class . '@edit');
$router->post('/admin/products/update', BackendProductsController::class . '@update');
$router->post('/admin/products/delete', BackendProductsController::class . '@delete');

// Options
$router->get('/admin/options', ProductOptionsController::class . '@index');
$router->post('/admin/options/store', ProductOptionsController::class . '@store');
$router->post('/admin/options/update', ProductOptionsController::class . '@update');
$router->post('/admin/options/delete', ProductOptionsController::class . '@delete');

// Gallery
$router->get('/admin/gallery', ProductImagesController::class . '@index');
$router->post('/admin/gallery/store', ProductImagesController::class . '@store');
$router->post('/admin/gallery/delete', ProductImagesController::class . '@delete');

// Admins
$router->get('/admin/admins', AdminsController::class . '@index');
$router->post('/admin/admins/store', AdminsController::class . '@store');
$router->post('/admin/admins/update', AdminsController::class . '@update');
$router->post('/admin/admins/delete', AdminsController::class . '@delete');

// Admin contacts
$router->get('/admin/admin-contacts', AdminContactsController::class . '@index');
$router->post('/admin/admin-contacts/store', AdminContactsController::class . '@store');
$router->post('/admin/admin-contacts/update', AdminContactsController::class . '@update');
$router->post('/admin/admin-contacts/delete', AdminContactsController::class . '@delete');

// Blog categories
$router->get('/admin/blog-categories', BlogCategoriesController::class . '@index');
$router->post('/admin/blog-categories/store', BlogCategoriesController::class . '@store');
$router->post('/admin/blog-categories/update', BlogCategoriesController::class . '@update');
$router->post('/admin/blog-categories/delete', BlogCategoriesController::class . '@delete');

// Blogs
$router->get('/admin/blogs', BackendBlogsController::class . '@index');
$router->post('/admin/blogs/store', BackendBlogsController::class . '@store');
$router->post('/admin/blogs/update', BackendBlogsController::class . '@update');
$router->post('/admin/blogs/delete', BackendBlogsController::class . '@delete');

// CSV import
$router->get('/admin/csv-import', CsvController::class . '@index');
$router->post('/admin/csv-import/upload', CsvController::class . '@import');

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$router->dispatch($path, $_SERVER['REQUEST_METHOD']);

