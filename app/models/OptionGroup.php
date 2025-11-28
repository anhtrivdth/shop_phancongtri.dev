<?php

class OptionGroup extends Model
{
    protected string $table = 'product_option_groups';
    protected array $fillable = ['product_id', 'name', 'display_type', 'position', 'required'];

    public function forProduct(int $productId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE product_id = :product_id ORDER BY position ASC");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll();
    }
}

