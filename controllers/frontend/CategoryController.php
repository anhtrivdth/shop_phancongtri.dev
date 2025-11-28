<?php
declare(strict_types=1);

namespace Controllers\Frontend;

use Core\Controller;
use Core\Functions;
use Models\CategoryLevel2;
use Models\Product;

class CategoryController extends Controller
{
    public function show(): void
    {
        $slug = Functions::sanitize($_GET['slug'] ?? '');
        if ($slug === '') {
            http_response_code(404);
            echo 'Category not found';
            return;
        }

        $categoryModel = new CategoryLevel2($this->db);
        $category = $categoryModel->findBySlugWithParent($slug);

        if (!$category) {
            http_response_code(404);
            echo 'Category not found';
            return;
        }

        $productModel = new Product($this->db);
        $products = $productModel->getByCategory((int) $category['id']);

        $this->render('frontend/category.php', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}

