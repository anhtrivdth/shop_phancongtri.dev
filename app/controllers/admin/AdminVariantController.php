<?php

class AdminVariantController extends AdminBaseController
{
    private ProductVariant $variant;
    private Product $product;

    public function __construct()
    {
        $this->variant = new ProductVariant();
        $this->product = new Product();
        parent::__construct();
    }

    public function index(): string
    {
        return $this->view('admin/variants/index', [
            'title' => 'Variants',
            'variants' => $this->variant->all('created_at DESC'),
            'products' => $this->product->all('name ASC'),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->guardCsrf();
        $this->variant->create([
            'product_id' => (int)$_POST['product_id'],
            'sku' => Security::sanitize($_POST['sku'] ?? ''),
            'price' => (float)$_POST['price'],
            'status_text' => Security::sanitize($_POST['status_text'] ?? ''),
            'is_active' => isset($_POST['is_active']),
        ]);
        $this->redirect("/{$this->appConfig['admin_base']}/variants");
    }

    private function guardCsrf(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF failed');
        }
    }
}

