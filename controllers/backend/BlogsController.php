<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Core\Functions;
use Models\Blog;
use Models\BlogCategory;

class BlogsController extends BaseAdminController
{
    private Blog $model;
    private BlogCategory $categoryModel;

    public function __construct(\PDO $db)
    {
        parent::__construct($db);
        $this->model = new Blog($db);
        $this->categoryModel = new BlogCategory($db);
    }

    public function index(): void
    {
        $this->render('backend/blogs/index.php', [
            'blogs'      => $this->model->all('created_at DESC'),
            'categories' => $this->categoryModel->all('name ASC'),
        ]);
    }

    public function store(): void
    {
        $input = Functions::sanitize($_POST);
        $slug = $input['slug'] ?: Functions::generateSlug($input['title']);
        $thumbnail = null;

        if (!empty($_FILES['thumbnail']['name'])) {
            try {
                $thumbnail = $this->handleUpload($_FILES['thumbnail'], $slug);
            } catch (\Throwable $throwable) {
                Functions::flash('error', $throwable->getMessage());
                $this->redirect('/admin/blogs');
            }
        }

        $this->model->create([
            'category_id' => (int) $input['category_id'],
            'title'       => $input['title'],
            'slug'        => $slug,
            'content'     => $input['content'] ?? '',
            'thumbnail'   => $thumbnail,
            'seo_title'   => $input['seo_title'] ?? '',
            'seo_desc'    => $input['seo_desc'] ?? '',
            'created_at'  => gmdate('Y-m-d H:i:s'),
        ]);

        Functions::flash('success', 'Blog created.');
        $this->redirect('/admin/blogs');
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $blog = $this->model->find($id);

        if (!$blog) {
            Functions::flash('error', 'Blog not found.');
            $this->redirect('/admin/blogs');
        }

        $input = Functions::sanitize($_POST);
        $slug = $input['slug'] ?: Functions::generateSlug($input['title']);
        $thumbnail = $blog['thumbnail'];

        if (!empty($_FILES['thumbnail']['name'])) {
            try {
                $thumbnail = $this->handleUpload($_FILES['thumbnail'], $slug);
            } catch (\Throwable $throwable) {
                Functions::flash('error', $throwable->getMessage());
                $this->redirect('/admin/blogs');
            }
        }

        $this->model->update($id, [
            'category_id' => (int) $input['category_id'],
            'title'       => $input['title'],
            'slug'        => $slug,
            'content'     => $input['content'] ?? '',
            'thumbnail'   => $thumbnail,
            'seo_title'   => $input['seo_title'] ?? '',
            'seo_desc'    => $input['seo_desc'] ?? '',
        ]);

        Functions::flash('success', 'Blog updated.');
        $this->redirect('/admin/blogs');
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->model->delete($id);
        Functions::flash('success', 'Blog deleted.');
        $this->redirect('/admin/blogs');
    }
}

