<?php

class AdminBannerController extends AdminBaseController
{
    private Banner $banner;

    public function __construct()
    {
        $this->banner = new Banner();
        parent::__construct();
    }

    public function index(): string
    {
        return $this->view('admin/banners/index', [
            'title' => 'Banners',
            'banners' => $this->banner->all('position ASC'),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->guardCsrf();
        $this->banner->create([
            'title' => Security::sanitize($_POST['title'] ?? ''),
            'subtitle' => Security::sanitize($_POST['subtitle'] ?? ''),
            'image_url' => Security::sanitize($_POST['image_url'] ?? ''),
            'button_label' => Security::sanitize($_POST['button_label'] ?? ''),
            'button_url' => Security::sanitize($_POST['button_url'] ?? ''),
            'position' => (int)($_POST['position'] ?? 0),
            'is_active' => isset($_POST['is_active']),
        ]);
        $this->redirect("/{$this->appConfig['admin_base']}/banners");
    }

    private function guardCsrf(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF failed');
        }
    }
}

