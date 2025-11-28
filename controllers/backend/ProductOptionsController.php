<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Core\Functions;
use Models\Product;
use Models\ProductOption;

class ProductOptionsController extends BaseAdminController
{
    private ProductOption $model;
    private Product $productModel;

    public function __construct(\PDO $db)
    {
        parent::__construct($db);
        $this->model = new ProductOption($db);
        $this->productModel = new Product($db);
    }

    public function index(): void
    {
        $this->render('backend/options/index.php', [
            'options'  => $this->model->all('created_at DESC'),
            'products' => $this->productModel->all('name ASC'),
        ]);
    }

    public function store(): void
    {
        $input = Functions::sanitize($_POST);
        $slug = $input['slug'] ?: Functions::generateSlug($input['name']);
        $image = null;

        if (!empty($_FILES['image']['name'])) {
            try {
                $image = $this->handleUpload($_FILES['image'], $slug);
            } catch (\Throwable $throwable) {
                Functions::flash('error', $throwable->getMessage());
                $this->redirect('/admin/options');
            }
        }

        $this->model->create([
            'product_id' => (int) $input['product_id'],
            'name'       => $input['name'],
            'price'      => (float) $input['price'],
            'image'      => $image,
            'status'     => (int) ($input['status'] ?? 1),
            'created_at' => gmdate('Y-m-d H:i:s'),
        ]);

        Functions::flash('success', 'Option created.');
        $this->redirect('/admin/options');
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $option = $this->model->find($id);

        if (!$option) {
            Functions::flash('error', 'Option not found.');
            $this->redirect('/admin/options');
        }

        $input = Functions::sanitize($_POST);
        $image = $option['image'];

        if (!empty($_FILES['image']['name'])) {
            try {
                $image = $this->handleUpload($_FILES['image'], Functions::generateSlug($input['name']));
            } catch (\Throwable $throwable) {
                Functions::flash('error', $throwable->getMessage());
                $this->redirect('/admin/options');
            }
        }

        $this->model->update($id, [
            'product_id' => (int) $input['product_id'],
            'name'       => $input['name'],
            'price'      => (float) $input['price'],
            'image'      => $image,
            'status'     => (int) ($input['status'] ?? 1),
        ]);

        Functions::flash('success', 'Option updated.');
        $this->redirect('/admin/options');
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->model->delete($id);
        Functions::flash('success', 'Option deleted.');
        $this->redirect('/admin/options');
    }
}

