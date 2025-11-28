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
        $stmt = $this->db->prepare("
            INSERT INTO cart_items (cart_id, product_id, variant_id, quantity)
            VALUES (:cart_id, :product_id, :variant_id, :quantity)
            ON CONFLICT (cart_id, variant_id) DO UPDATE SET quantity = cart_items.quantity + EXCLUDED.quantity
        ");
        $stmt->execute($data);
    }

    public function countByCart(string $cartId): int
    {
        $stmt = $this->db->prepare("SELECT COALESCE(SUM(quantity), 0) FROM cart_items WHERE cart_id = :cart_id");
        $stmt->execute(['cart_id' => $cartId]);
        return (int)$stmt->fetchColumn();
    }
}

