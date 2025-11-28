<?php

class CartItem extends Model
{
    protected string $table = 'cart_items';
    protected array $fillable = ['cart_id', 'product_id', 'variant_id', 'quantity'];

    public function forCart(string $cartId): array
    {
        $sql = "
            SELECT ci.*, p.name, p.slug, pv.price
            FROM cart_items ci
            JOIN products p ON p.id = ci.product_id
            LEFT JOIN product_variants pv ON pv.id = ci.variant_id
            WHERE ci.cart_id = :cart_id
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['cart_id' => $cartId]);
        return $stmt->fetchAll();
    }

    public function upsert(array $data): void
    {
        $existing = $this->findExistingItem($data);
        if ($existing) {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET quantity = quantity + :quantity, updated_at = NOW() WHERE id = :id");
            $stmt->execute([
                'quantity' => $data['quantity'],
                'id' => $existing['id'],
            ]);
            return;
        }

        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (cart_id, product_id, variant_id, quantity, created_at, updated_at)
            VALUES (:cart_id, :product_id, :variant_id, :quantity, NOW(), NOW())
        ");
        $stmt->execute($data);
    }

    public function countByCart(string $cartId): int
    {
        $stmt = $this->db->prepare("SELECT COALESCE(SUM(quantity), 0) FROM cart_items WHERE cart_id = :cart_id");
        $stmt->execute(['cart_id' => $cartId]);
        return (int)$stmt->fetchColumn();
    }

    private function findExistingItem(array $data): ?array
    {
        $sql = "SELECT id FROM {$this->table} WHERE cart_id = :cart_id AND product_id = :product_id";
        $params = [
            'cart_id' => $data['cart_id'],
            'product_id' => $data['product_id'],
        ];

        if (!empty($data['variant_id'])) {
            $sql .= " AND variant_id = :variant_id";
            $params['variant_id'] = $data['variant_id'];
        } else {
            $sql .= " AND variant_id IS NULL";
        }

        $sql .= " LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}

