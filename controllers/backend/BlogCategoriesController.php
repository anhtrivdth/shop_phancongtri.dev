<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Core\Functions;
use Models\BlogCategory;

class BlogCategoriesController extends BaseAdminController
{
    private BlogCategory $model;

    public function __construct(\PDO $db)
    {
        parent::__construct($db);
        $this->model = new BlogCategory($db);
    }

    public function index(): void
    {
        $this->render('backend/blog_categories/index.php', [
            'categories' => $this->model->all('name ASC'),
        ]);
    }

    public function store(): void
    {
        $input = Functions::sanitize($_POST);
        $slug = $input['slug'] ?: Functions::generateSlug($input['name']);

        $this->model->create([
            'name' => $input['name'],
            'slug' => $slug,
        ]);

        Functions::flash('success', 'Blog category created.');
        $this->redirect('/admin/blog-categories');
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $input = Functions::sanitize($_POST);
        $slug = $input['slug'] ?: Functions::generateSlug($input['name']);

        $this->model->update($id, [
            'name' => $input['name'],
            'slug' => $slug,
        ]);

        Functions::flash('success', 'Blog category updated.');
        $this->redirect('/admin/blog-categories');
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->model->delete($id);
        Functions::flash('success', 'Blog category deleted.');
        $this->redirect('/admin/blog-categories');
    }
}

