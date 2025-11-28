<?php

class ContactLink extends Model
{
    protected string $table = 'contact_links';
    protected array $fillable = ['type', 'url', 'is_active', 'position'];

    public function enabled(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE is_active = TRUE ORDER BY position ASC");
        return $stmt->fetchAll();
    }
}

