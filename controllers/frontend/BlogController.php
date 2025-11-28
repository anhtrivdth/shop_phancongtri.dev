<?php
declare(strict_types=1);

namespace Controllers\Frontend;

use Core\Controller;
use Core\Functions;
use Models\Blog;
use Models\BlogCategory;

class BlogController extends Controller
{
    public function index(): void
    {
        $categoryModel = new BlogCategory($this->db);
        $blogModel = new Blog($this->db);

        $this->render('frontend/blog.php', [
            'categories' => $categoryModel->all('name ASC'),
            'blogs'      => $blogModel->latest(),
        ]);
    }

    public function detail(): void
    {
        $slug = Functions::sanitize($_GET['slug'] ?? '');
        if ($slug === '') {
            http_response_code(404);
            echo 'Blog not found';
            return;
        }

        $blogModel = new Blog($this->db);
        $blog = $blogModel->findBySlugWithCategory($slug);

        if (!$blog) {
            http_response_code(404);
            echo 'Blog not found';
            return;
        }

        $related = $blogModel->related((int) $blog['category_id'], (int) $blog['id']);

        $this->render('frontend/blog_detail.php', [
            'blog'    => $blog,
            'related' => $related,
        ]);
    }
}

