<?php

class HomeController extends Controller
{
    private Product $product;
    private BlogPost $blogPost;
    private Banner $banner;
    private PopupSetting $popup;
    private ContactLink $contactLink;

    public function __construct()
    {
        parent::__construct();
        $this->product = new Product();
        $this->blogPost = new BlogPost();
        $this->banner = new Banner();
        $this->popup = new PopupSetting();
        $this->contactLink = new ContactLink();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Trang chủ',
            'banners' => $this->banner->active(),
            'featured' => $this->product->featured(),
            'recommended' => $this->product->pinned(),
            'blogPosts' => $this->blogPost->latest(),
            'popup' => $this->popup->active(),
            'contactLinks' => $this->contactLink->enabled(),
        ];

        return $this->view('frontend/home', $data);
    }
}

