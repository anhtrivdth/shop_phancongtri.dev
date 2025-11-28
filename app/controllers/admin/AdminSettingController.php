<?php

class AdminSettingController extends AdminBaseController
{
    private SiteSetting $setting;

    public function __construct()
    {
        $this->setting = new SiteSetting();
        parent::__construct();
    }

    public function index(): string
    {
        return $this->view('admin/settings/index', [
            'title' => 'Site Settings',
            'setting' => $this->setting->current(),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->guardCsrf();
        $this->setting->create([
            'dark_mode_default' => isset($_POST['dark_mode_default']),
            'hero_search_placeholder' => Security::sanitize($_POST['hero_search_placeholder'] ?? ''),
            'admin_base_path' => Helper::slugify($_POST['admin_base_path'] ?? 'admin'),
        ]);
        $this->redirect("/{$this->appConfig['admin_base']}/settings");
    }

    private function guardCsrf(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF failed');
        }
    }
}

