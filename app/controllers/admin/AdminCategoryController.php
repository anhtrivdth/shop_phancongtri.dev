<?php

class AdminCategoryController extends AdminBaseController
{
    private Category $category;
    private ServiceType $serviceType;

    public function __construct()
    {
        $this->category = new Category();
        $this->serviceType = new ServiceType();
        parent::__construct();
    }

    public function index(): string
    {
        $items = $this->category->all('position ASC');
        return $this->view('admin/categories/index', [
            'title' => 'Danh mục',
            'items' => $items,
            'serviceTypes' => $this->serviceType->active(),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->guardCsrf();
        $this->category->create([
            'service_type_id' => (int)$_POST['service_type_id'],
            'name' => Security::sanitize($_POST['name'] ?? ''),
            'slug' => Helper::slugify($_POST['slug'] ?? $_POST['name'] ?? ''),
            'is_active' => isset($_POST['is_active']),
            'position' => (int)($_POST['position'] ?? 0),
        ]);
        $this->redirect("/{$this->appConfig['admin_base']}/categories");
    }

    public function update(int $id): void
    {
        $this->guardCsrf();
        $this->category->update($id, [
            'service_type_id' => (int)$_POST['service_type_id'],
            'name' => Security::sanitize($_POST['name'] ?? ''),
            'slug' => Helper::slugify($_POST['slug'] ?? $_POST['name'] ?? ''),
            'is_active' => isset($_POST['is_active']),
            'position' => (int)($_POST['position'] ?? 0),
        ]);
        $this->redirect("/{$this->appConfig['admin_base']}/categories");
    }

    public function destroy(int $id): void
    {
        $this->guardCsrf();
        $this->category->delete($id);
        $this->redirect("/{$this->appConfig['admin_base']}/categories");
    }

    private function guardCsrf(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF failed');
        }
    }
}

