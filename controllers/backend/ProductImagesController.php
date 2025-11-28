<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Core\Functions;
use Models\Product;
use Models\ProductImage;

class ProductImagesController extends BaseAdminController
{
    private ProductImage $model;
    private Product $productModel;

    public function __construct(\PDO $db)
    {
        parent::__construct($db);
        $this->model = new ProductImage($db);
        $this->productModel = new Product($db);
    }

    public function index(): void
    {
        $this->render('backend/gallery/index.php', [
            'images'   => $this->model->all('id DESC'),
            'products' => $this->productModel->all('name ASC'),
        ]);
    }

    public function store(): void
    {
        $input = Functions::sanitize($_POST);

        if (empty($_FILES['image']['name'])) {
            Functions::flash('error', 'Image is required.');
            $this->redirect('/admin/gallery');
        }

        try {
            $filename = $this->handleUpload(
                $_FILES['image'],
                Functions::generateSlug($input['product_id'] . '-gallery')
            );
        } catch (\Throwable $throwable) {
            Functions::flash('error', $throwable->getMessage());
            $this->redirect('/admin/gallery');
        }

        $this->model->create([
            'product_id' => (int) $input['product_id'],
            'image'      => $filename,
        ]);

        Functions::flash('success', 'Image added.');
        $this->redirect('/admin/gallery');
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->model->delete($id);
        Functions::flash('success', 'Image removed.');
        $this->redirect('/admin/gallery');
    }
}

