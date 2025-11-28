<?php

class AdminDashboardController extends AdminBaseController
{
    private Product $product;
    private Review $review;
    private BlogPost $blogPost;

    public function __construct()
    {
        $this->product = new Product();
        $this->review = new Review();
        $this->blogPost = new BlogPost();
        parent::__construct();
    }

    public function index(): string
    {
        return $this->view('admin/dashboard/index', [
            'title' => 'Dashboard',
            'productCount' => count($this->product->all()),
            'reviewCount' => count($this->review->all()),
            'blogCount' => count($this->blogPost->all()),
        ]);
    }
}

