<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Core\Functions;
use Models\CategoryLevel1;
use Models\CategoryLevel2;

class CategoriesLvl2Controller extends BaseAdminController
{
    private CategoryLevel2 $model;
    private CategoryLevel1 $parentModel;

    public function __construct(\PDO $db)
    {
        parent::__construct($db);
        $this->model = new CategoryLevel2($db);
        $this->parentModel = new CategoryLevel1($db);
    }

    public function index(): void
    {
        $this->render('backend/categories_lvl2/index.php', [
            'categories' => $this->model->all('created_at DESC'),
            'parents'    => $this->parentModel->all('name ASC'),
        ]);
    }

    public function create(): void
    {
        $this->render('backend/categories_lvl2/create.php', [
            'parents' => $this->parentModel->all('name ASC'),
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
                $this->redirect('/admin/categories/lvl2');
            }
        }

        $this->model->create([
            'lvl1_id'    => (int) $input['lvl1_id'],
            'name'       => $input['name'],
            'slug'       => $slug,
            'image'      => $image,
            'created_at' => gmdate('Y-m-d H:i:s'),
        ]);

        Functions::flash('success', 'Level 2 category created.');
        $this->redirect('/admin/categories/lvl2');
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $category = $this->model->find($id);

        if (!$category) {
            Functions::flash('error', 'Category not found.');
            $this->redirect('/admin/categories/lvl2');
        }

        $this->render('backend/categories_lvl2/edit.php', [
            'category' => $category,
            'parents'  => $this->parentModel->all('name ASC'),
        ]);
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $category = $this->model->find($id);

        if (!$category) {
            Functions::flash('error', 'Category not found.');
            $this->redirect('/admin/categories/lvl2');
        }

        $input = Functions::sanitize($_POST);
        $slug = $input['slug'] ?: Functions::generateSlug($input['name']);
        $image = $category['image'];

        if (!empty($_FILES['image']['name'])) {
            try {
                $image = $this->handleUpload($_FILES['image'], $slug);
            } catch (\Throwable $throwable) {
                Functions::flash('error', $throwable->getMessage());
                $this->redirect('/admin/categories/lvl2');
            }
        }

        $this->model->update($id, [
            'lvl1_id' => (int) $input['lvl1_id'],
            'name'    => $input['name'],
            'slug'    => $slug,
            'image'   => $image,
        ]);

        Functions::flash('success', 'Category updated.');
        $this->redirect('/admin/categories/lvl2');
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->model->delete($id);
        Functions::flash('success', 'Category deleted.');
        $this->redirect('/admin/categories/lvl2');
    }
}

