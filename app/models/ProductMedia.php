<?php

class ProductMedia extends Model
{
    protected string $table = 'product_media';
    protected array $fillable = ['product_id', 'image_url', 'alt_text', 'position'];

    public function forProduct(int $productId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE product_id = :product_id ORDER BY position ASC");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll();
    }
}

