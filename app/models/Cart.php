<?php

class Cart extends Model
{
    protected string $table = 'carts';
    protected array $fillable = [];

    public function createCart(): string
    {
        $stmt = $this->db->query("INSERT INTO {$this->table} DEFAULT VALUES RETURNING id");
        return $stmt->fetchColumn();
    }
}

