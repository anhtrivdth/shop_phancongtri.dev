<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Core\Functions;
use Models\CategoryLevel2;
use Models\Product;

class ProductsController extends BaseAdminController
{
    private Product $model;
    private CategoryLevel2 $categoryModel;

    public function __construct(\PDO $db)
    {
        parent::__construct($db);
        $this->model = new Product($db);
        $this->categoryModel = new CategoryLevel2($db);
    }

    public function index(): void
    {
        $this->render('backend/products/index.php', [
            'products'   => $this->model->all('created_at DESC'),
            'categories' => $this->categoryModel->all('name ASC'),
        ]);
    }

    public function create(): void
    {
        $this->render('backend/products/create.php', [
            'categories' => $this->categoryModel->all('name ASC'),
        ]);
    }

    public function store(): void
    {
        $input = Functions::sanitize($_POST);
        $slug = $input['slug'] ?: Functions::generateSlug($input['name']);
        $thumbnail = null;

        if (!empty($_FILES['thumbnail']['name'])) {
            try {
                $thumbnail = $this->handleUpload($_FILES['thumbnail'], $slug);
            } catch (\Throwable $throwable) {
                Functions::flash('error', $throwable->getMessage());
                $this->redirect('/admin/products');
            }
        }

        $this->model->create([
            'lvl2_id'    => (int) $input['lvl2_id'],
            'name'       => $input['name'],
            'slug'       => $slug,
            'description'=> $input['description'] ?? '',
            'thumbnail'  => $thumbnail,
            'status'     => (int) ($input['status'] ?? 1),
            'views'      => 0,
            'created_at' => gmdate('Y-m-d H:i:s'),
        ]);

        Functions::flash('success', 'Product created.');
        $this->redirect('/admin/products');
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $product = $this->model->find($id);

        if (!$product) {
            Functions::flash('error', 'Product not found.');
            $this->redirect('/admin/products');
        }

        $this->render('backend/products/edit.php', [
            'product'    => $product,
            'categories' => $this->categoryModel->all('name ASC'),
        ]);
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $product = $this->model->find($id);

        if (!$product) {
            Functions::flash('error', 'Product not found.');
            $this->redirect('/admin/products');
        }

        $input = Functions::sanitize($_POST);
        $slug = $input['slug'] ?: Functions::generateSlug($input['name']);
        $thumbnail = $product['thumbnail'];

        if (!empty($_FILES['thumbnail']['name'])) {
            try {
                $thumbnail = $this->handleUpload($_FILES['thumbnail'], $slug);
            } catch (\Throwable $throwable) {
                Functions::flash('error', $throwable->getMessage());
                $this->redirect('/admin/products');
            }
        }

        $this->model->update($id, [
            'lvl2_id'    => (int) $input['lvl2_id'],
            'name'       => $input['name'],
            'slug'       => $slug,
            'description'=> $input['description'] ?? '',
            'thumbnail'  => $thumbnail,
            'status'     => (int) ($input['status'] ?? 1),
        ]);

        Functions::flash('success', 'Product updated.');
        $this->redirect('/admin/products');
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->model->delete($id);
        Functions::flash('success', 'Product deleted.');
        $this->redirect('/admin/products');
    }
}

