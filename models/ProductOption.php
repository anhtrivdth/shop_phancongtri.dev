<?php
declare(strict_types=1);

namespace Models;

class ProductOption extends BaseModel
{
    protected string $table = 'product_options';

    public function getByProduct(int $productId): array
    {
        $statement = $this->db->prepare("SELECT * FROM {$this->table} WHERE product_id = :product_id ORDER BY created_at ASC");
        $statement->execute(['product_id' => $productId]);

        return $statement->fetchAll();
    }
}

