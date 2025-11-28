<?php

class BlogController extends Controller
{
    private BlogPost $blogPost;

    public function __construct()
    {
        parent::__construct();
        $this->blogPost = new BlogPost();
    }

    public function index(): string
    {
        $posts = $this->blogPost->latest(20);
        return $this->view('frontend/blog/index', [
            'title' => 'Tin tức',
            'posts' => $posts,
        ]);
    }

    public function show(string $slug): string
    {
        $post = $this->blogPost->findBySlug($slug);
        if (!$post || !$post['is_visible']) {
            http_response_code(404);
            return $this->view('frontend/404', ['title' => 'Không tìm thấy bài viết']);
        }

        return $this->view('frontend/blog/show', [
            'title' => $post['title'],
            'post' => $post,
        ]);
    }
}

