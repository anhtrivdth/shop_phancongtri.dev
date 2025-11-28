<?php

class Banner extends Model
{
    protected string $table = 'banners';
    protected array $fillable = ['title', 'subtitle', 'image_url', 'button_label', 'button_url', 'is_active', 'position'];

    public function active(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE is_active = TRUE ORDER BY position ASC");
        return $stmt->fetchAll();
    }
}

