<?php

class AdminServiceTypeController extends AdminBaseController
{
    private ServiceType $serviceType;

    public function __construct()
    {
        $this->serviceType = new ServiceType();
        parent::__construct();
    }

    public function index(): string
    {
        return $this->view('admin/service_types/index', [
            'title' => 'Loại dịch vụ',
            'items' => $this->serviceType->all('position ASC'),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->handleCsrf();
        $data = [
            'name' => Security::sanitize($_POST['name'] ?? ''),
            'slug' => Helper::slugify($_POST['slug'] ?? $_POST['name'] ?? ''),
            'position' => (int)($_POST['position'] ?? 0),
            'is_active' => isset($_POST['is_active']),
        ];
        $this->serviceType->create($data);
        $this->redirect("/{$this->appConfig['admin_base']}/service-types");
    }

    public function update(int $id): void
    {
        $this->handleCsrf();
        $data = [
            'name' => Security::sanitize($_POST['name'] ?? ''),
            'slug' => Helper::slugify($_POST['slug'] ?? $_POST['name'] ?? ''),
            'position' => (int)($_POST['position'] ?? 0),
            'is_active' => isset($_POST['is_active']),
        ];
        $this->serviceType->update($id, $data);
        $this->redirect("/{$this->appConfig['admin_base']}/service-types");
    }

    public function destroy(int $id): void
    {
        $this->handleCsrf();
        $this->serviceType->delete($id);
        $this->redirect("/{$this->appConfig['admin_base']}/service-types");
    }

    private function handleCsrf(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF failed');
        }
    }
}

