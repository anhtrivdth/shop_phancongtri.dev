<?php

class AdminBlogController extends AdminBaseController
{
    private BlogPost $blogPost;

    public function __construct()
    {
        $this->blogPost = new BlogPost();
        parent::__construct();
    }

    public function index(): string
    {
        return $this->view('admin/blog/index', [
            'title' => 'Tin tức',
            'posts' => $this->blogPost->all('published_at DESC'),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->guardCsrf();
        $this->blogPost->create([
            'title' => Security::sanitize($_POST['title'] ?? ''),
            'slug' => Helper::slugify($_POST['slug'] ?? $_POST['title'] ?? ''),
            'cover_image' => Security::sanitize($_POST['cover_image'] ?? ''),
            'excerpt' => Security::sanitize($_POST['excerpt'] ?? ''),
            'content' => Security::sanitize($_POST['content'] ?? ''),
            'is_visible' => isset($_POST['is_visible']),
            'published_at' => $_POST['published_at'] ?? date('Y-m-d H:i:s'),
        ]);
        $this->redirect("/{$this->appConfig['admin_base']}/blog");
    }

    private function guardCsrf(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF failed');
        }
    }
}

