<?php
declare(strict_types=1);

namespace Models;

class ProductImage extends BaseModel
{
    protected string $table = 'product_images';

    public function getByProduct(int $productId): array
    {
        $statement = $this->db->prepare("SELECT * FROM {$this->table} WHERE product_id = :product_id");
        $statement->execute(['product_id' => $productId]);

        return $statement->fetchAll();
    }
}

