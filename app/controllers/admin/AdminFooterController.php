<?php

class AdminFooterController extends AdminBaseController
{
    private FooterSetting $footer;

    public function __construct()
    {
        $this->footer = new FooterSetting();
        parent::__construct();
    }

    public function index(): string
    {
        return $this->view('admin/footer/index', [
            'title' => 'Footer Settings',
            'footer' => $this->footer->current(),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->guardCsrf();
        $this->footer->create([
            'logo_url' => Security::sanitize($_POST['logo_url'] ?? ''),
            'description' => Security::sanitize($_POST['description'] ?? ''),
            'qr_code_url' => Security::sanitize($_POST['qr_code_url'] ?? ''),
            'mini_banner_url' => Security::sanitize($_POST['mini_banner_url'] ?? ''),
            'copyright_text' => Security::sanitize($_POST['copyright_text'] ?? ''),
            'policies' => json_encode($_POST['policies'] ?? []),
            'quick_links' => json_encode($_POST['quick_links'] ?? []),
        ]);
        $this->redirect("/{$this->appConfig['admin_base']}/footer");
    }

    private function guardCsrf(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF failed');
        }
    }
}

