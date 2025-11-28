<?php

class AdminOptionController extends AdminBaseController
{
    private OptionGroup $group;
    private OptionValue $value;
    private Product $product;

    public function __construct()
    {
        $this->group = new OptionGroup();
        $this->value = new OptionValue();
        $this->product = new Product();
        parent::__construct();
    }

    public function groups(): string
    {
        return $this->view('admin/options/groups', [
            'title' => 'Option Groups',
            'groups' => $this->group->all('position ASC'),
            'products' => $this->product->all('name ASC'),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function storeGroup(): void
    {
        $this->guardCsrf();
        $this->group->create([
            'product_id' => (int)$_POST['product_id'],
            'name' => Security::sanitize($_POST['name'] ?? ''),
            'display_type' => $_POST['display_type'] ?? 'buttons',
            'position' => (int)($_POST['position'] ?? 0),
            'required' => isset($_POST['required']),
        ]);
        $this->redirect("/{$this->appConfig['admin_base']}/options/groups");
    }

    public function values(): string
    {
        return $this->view('admin/options/values', [
            'title' => 'Option Values',
            'values' => $this->value->all('position ASC'),
            'groups' => $this->group->all('name ASC'),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function storeValue(): void
    {
        $this->guardCsrf();
        $this->value->create([
            'group_id' => (int)$_POST['group_id'],
            'value' => Security::sanitize($_POST['value'] ?? ''),
            'position' => (int)($_POST['position'] ?? 0),
        ]);
        $this->redirect("/{$this->appConfig['admin_base']}/options/values");
    }

    private function guardCsrf(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF failed');
        }
    }
}

