<?php

class Product extends Model
{
    protected string $table = 'products';
    protected array $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'status_text',
        'is_visible',
        'is_featured',
        'is_pinned',
        'min_price',
        'max_price',
        'review_enabled'
    ];

    public function visible(array $filters = []): array
    {
        $sql = "SELECT p.*, c.name AS category_name FROM {$this->table} p JOIN categories c ON c.id = p.category_id WHERE p.is_visible = TRUE";
        $params = [];

        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (p.name ILIKE :search OR p.slug ILIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        $sort = $filters['sort'] ?? 'newest';
        $order = match ($sort) {
            'price_asc' => 'p.min_price ASC NULLS LAST',
            'price_desc' => 'p.max_price DESC NULLS LAST',
            'popular' => 'p.is_featured DESC, p.updated_at DESC',
            default => 'p.created_at DESC',
        };

        $sql .= " ORDER BY {$order}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function featured(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE is_featured = TRUE AND is_visible = TRUE ORDER BY updated_at DESC LIMIT 8");
        return $stmt->fetchAll();
    }

    public function pinned(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE is_pinned = TRUE AND is_visible = TRUE ORDER BY updated_at DESC LIMIT 8");
        return $stmt->fetchAll();
    }

    public function updatePriceRange(int $productId): void
    {
        $stmt = $this->db->prepare("SELECT MIN(price) AS min_price, MAX(price) AS max_price FROM product_variants WHERE product_id = :product_id AND is_active = TRUE");
        $stmt->execute(['product_id' => $productId]);
        $range = $stmt->fetch();
        $this->update($productId, [
            'min_price' => $range['min_price'],
            'max_price' => $range['max_price'],
        ]);
    }
}

