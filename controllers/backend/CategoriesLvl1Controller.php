<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Core\Functions;
use Models\CategoryLevel1;

class CategoriesLvl1Controller extends BaseAdminController
{
    private CategoryLevel1 $model;

    public function __construct(\PDO $db)
    {
        parent::__construct($db);
        $this->model = new CategoryLevel1($db);
    }

    public function index(): void
    {
        $this->render('backend/categories_lvl1/index.php', [
            'categories' => $this->model->all('created_at DESC'),
            'success'    => Functions::flash('success'),
            'error'      => Functions::flash('error'),
        ]);
    }

    public function create(): void
    {
        $this->render('backend/categories_lvl1/create.php', []);
    }

    public function store(): void
    {
        $input = Functions::sanitize($_POST);
        $errors = $this->validate([
            'name' => 'required',
        ], $input);

        if ($errors) {
            Functions::flash('error', 'Name is required.');
            $this->redirect('/admin/categories');
        }

        $slug = $input['slug'] ?: Functions::generateSlug($input['name']);
        $iconPath = null;

        if (isset($_FILES['icon'])) {
            try {
                $iconPath = $this->handleUpload($_FILES['icon'], $slug);
            } catch (\Throwable $throwable) {
                Functions::flash('error', $throwable->getMessage());
                $this->redirect('/admin/categories');
            }
        }

        $this->model->create([
            'name'       => $input['name'],
            'slug'       => $slug,
            'icon'       => $iconPath,
            'created_at' => gmdate('Y-m-d H:i:s'),
        ]);

        Functions::flash('success', 'Category created.');
        $this->redirect('/admin/categories');
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $category = $this->model->find($id);

        if (!$category) {
            Functions::flash('error', 'Category not found.');
            $this->redirect('/admin/categories');
        }

        $this->render('backend/categories_lvl1/edit.php', [
            'category' => $category,
        ]);
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $category = $this->model->find($id);

        if (!$category) {
            Functions::flash('error', 'Category not found.');
            $this->redirect('/admin/categories');
        }

        $input = Functions::sanitize($_POST);
        $slug = $input['slug'] ?: Functions::generateSlug($input['name']);
        $icon = $category['icon'];

        if (!empty($_FILES['icon']['name'])) {
            try {
                $icon = $this->handleUpload($_FILES['icon'], $slug);
            } catch (\Throwable $throwable) {
                Functions::flash('error', $throwable->getMessage());
                $this->redirect('/admin/categories');
            }
        }

        $this->model->update($id, [
            'name' => $input['name'],
            'slug' => $slug,
            'icon' => $icon,
        ]);

        Functions::flash('success', 'Category updated.');
        $this->redirect('/admin/categories');
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? ($_GET['id'] ?? 0));
        $this->model->delete($id);
        Functions::flash('success', 'Category deleted.');
        $this->redirect('/admin/categories');
    }
}

