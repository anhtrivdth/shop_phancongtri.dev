<?php

class Cart extends Model
{
    protected string $table = 'carts';
    protected array $fillable = [];

    public function createCart(): string
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (created_at, updated_at) VALUES (NOW(), NOW())");
        $stmt->execute();
        return $this->db->lastInsertId();
    }
}

