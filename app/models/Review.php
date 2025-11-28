<?php

class Review extends Model
{
    protected string $table = 'reviews';
    protected array $fillable = ['product_id', 'nickname', 'rating', 'content', 'ip_address', 'is_hidden'];

    public function forProduct(int $productId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE product_id = :product_id AND is_hidden = FALSE ORDER BY created_at DESC");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll();
    }

    public function canPost(string $ipAddress): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE ip_address = :ip AND created_at >= (NOW() - INTERVAL '2 minutes')");
        $stmt->execute(['ip' => $ipAddress]);
        return (int)$stmt->fetchColumn() === 0;
    }
}

