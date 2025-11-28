<?php

class AdminPopupController extends AdminBaseController
{
    private PopupSetting $popup;

    public function __construct()
    {
        $this->popup = new PopupSetting();
        parent::__construct();
    }

    public function index(): string
    {
        return $this->view('admin/popup/index', [
            'title' => 'Popup',
            'popup' => $this->popup->active(),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->guardCsrf();
        $this->popup->create([
            'is_enabled' => isset($_POST['is_enabled']),
            'image_url' => Security::sanitize($_POST['image_url'] ?? ''),
            'title' => Security::sanitize($_POST['title'] ?? ''),
            'body' => Security::sanitize($_POST['body'] ?? ''),
            'action_label' => Security::sanitize($_POST['action_label'] ?? ''),
            'action_url' => Security::sanitize($_POST['action_url'] ?? ''),
        ]);
        $this->redirect("/{$this->appConfig['admin_base']}/popup");
    }

    private function guardCsrf(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF failed');
        }
    }
}

