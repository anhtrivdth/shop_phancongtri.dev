<?php

class ProductVariant extends Model
{
    protected string $table = 'product_variants';
    protected array $fillable = ['product_id', 'sku', 'price', 'status_text', 'is_active'];

    public function forProduct(int $productId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE product_id = :product_id AND is_active = TRUE ORDER BY price ASC");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll();
    }

    public function findByOptions(int $productId, array $optionValueIds): ?array
    {
        if (empty($optionValueIds)) {
            return null;
        }

        $placeholders = implode(', ', array_fill(0, count($optionValueIds), '?'));
        $sql = "
            SELECT pv.*
            FROM product_variants pv
            JOIN variant_option_values vov ON vov.variant_id = pv.id
            WHERE pv.product_id = ?
              AND vov.option_value_id IN ({$placeholders})
            GROUP BY pv.id
            HAVING COUNT(DISTINCT vov.option_value_id) = ?
        ";

        $params = array_merge([$productId], $optionValueIds, [count($optionValueIds)]);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $variant = $stmt->fetch();
        return $variant ?: null;
    }
}

