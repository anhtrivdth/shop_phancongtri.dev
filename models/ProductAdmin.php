<?php
declare(strict_types=1);

namespace Models;

class ProductAdmin extends BaseModel
{
    protected string $table = 'product_admin';

    public function getAdminsForProduct(int $productId): array
    {
        $query = "SELECT a.*, ac.*
                  FROM {$this->table} pa
                  INNER JOIN admins a ON a.id = pa.admin_id
                  LEFT JOIN admin_contacts ac ON ac.admin_id = a.id
                  WHERE pa.product_id = :product_id";
        $statement = $this->db->prepare($query);
        $statement->execute(['product_id' => $productId]);

        return $statement->fetchAll();
    }
}

