<?php
declare(strict_types=1);

namespace Controllers\Frontend;

use Core\Controller;
use Core\Functions;
use Models\AdminContact;
use Models\Product;
use Models\ProductAdmin;
use Models\ProductImage;
use Models\ProductOption;

class ProductController extends Controller
{
    public function show(): void
    {
        $slug = Functions::sanitize($_GET['slug'] ?? '');
        if ($slug === '') {
            http_response_code(404);
            echo 'Product not found';
            return;
        }

        $productModel = new Product($this->db);
        $product = $productModel->findWithRelations($slug);

        if (!$product) {
            http_response_code(404);
            echo 'Product not found';
            return;
        }

        $productModel->incrementViews((int) $product['id']);

        $options = (new ProductOption($this->db))->getByProduct((int) $product['id']);
        $images = (new ProductImage($this->db))->getByProduct((int) $product['id']);
        $admins = (new ProductAdmin($this->db))->getAdminsForProduct((int) $product['id']);
        $contactModel = new AdminContact($this->db);

        $contacts = [];
        foreach ($admins as $admin) {
            $contacts[$admin['id']] = $contactModel->getByAdmin((int) $admin['id']);
        }

        $this->render('frontend/product.php', [
            'product'  => $product,
            'options'  => $options,
            'images'   => $images,
            'admins'   => $admins,
            'contacts' => $contacts,
        ]);
    }
}

