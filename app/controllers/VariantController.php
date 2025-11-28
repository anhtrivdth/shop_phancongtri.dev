<?php

class VariantController extends Controller
{
    private ProductVariant $variant;

    public function __construct()
    {
        parent::__construct();
        $this->variant = new ProductVariant();
    }

    public function price(): void
    {
        header('Content-Type: application/json');

        $productId = (int)($_POST['product_id'] ?? 0);
        $optionValueIds = array_map('intval', $_POST['options'] ?? []);

        if (!$productId || empty($optionValueIds)) {
            echo json_encode(['success' => false, 'message' => 'Missing data']);
            return;
        }

        $variant = $this->variant->findByOptions($productId, $optionValueIds);
        if (!$variant) {
            echo json_encode(['success' => false, 'message' => 'Variant not found']);
            return;
        }

        echo json_encode([
            'success' => true,
            'price' => $variant['price'],
            'variant_id' => $variant['id'],
            'status_text' => $variant['status_text'],
        ]);
    }
}

