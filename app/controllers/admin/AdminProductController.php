<?php

class AdminProductController extends AdminBaseController
{
    private Product $product;
    private Category $category;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();
        parent::__construct();
    }

    public function index(): string
    {
        return $this->view('admin/products/index', [
            'title' => 'Sản phẩm',
            'items' => $this->product->all('created_at DESC'),
            'categories' => $this->category->all('name ASC'),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->guardCsrf();
        $id = $this->product->create($this->payload());
        $this->product->updatePriceRange($id);
        $this->redirect("/{$this->appConfig['admin_base']}/products");
    }

    public function update(int $id): void
    {
        $this->guardCsrf();
        $this->product->update($id, $this->payload());
        $this->product->updatePriceRange($id);
        $this->redirect("/{$this->appConfig['admin_base']}/products");
    }

    public function destroy(int $id): void
    {
        $this->guardCsrf();
        $this->product->delete($id);
        $this->redirect("/{$this->appConfig['admin_base']}/products");
    }

    private function payload(): array
    {
        return [
            'category_id' => (int)$_POST['category_id'],
            'name' => Security::sanitize($_POST['name'] ?? ''),
            'slug' => Helper::slugify($_POST['slug'] ?? $_POST['name'] ?? ''),
            'short_description' => Security::sanitize($_POST['short_description'] ?? ''),
            'description' => Security::sanitize($_POST['description'] ?? ''),
            'status_text' => Security::sanitize($_POST['status_text'] ?? ''),
            'is_visible' => isset($_POST['is_visible']),
            'is_featured' => isset($_POST['is_featured']),
            'is_pinned' => isset($_POST['is_pinned']),
            'review_enabled' => isset($_POST['review_enabled']),
        ];
    }

    private function guardCsrf(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF failed');
        }
    }
}

