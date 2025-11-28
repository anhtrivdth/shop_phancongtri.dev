<?php

class AdminContactController extends AdminBaseController
{
    private ContactLink $contactLink;

    public function __construct()
    {
        $this->contactLink = new ContactLink();
        parent::__construct();
    }

    public function index(): string
    {
        return $this->view('admin/contact/index', [
            'title' => 'Contact Links',
            'links' => $this->contactLink->all('position ASC'),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->guardCsrf();
        $this->contactLink->create([
            'type' => Security::sanitize($_POST['type'] ?? ''),
            'url' => Security::sanitize($_POST['url'] ?? ''),
            'is_active' => isset($_POST['is_active']),
            'position' => (int)($_POST['position'] ?? 0),
        ]);
        $this->redirect("/{$this->appConfig['admin_base']}/contact-links");
    }

    private function guardCsrf(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF failed');
        }
    }
}

