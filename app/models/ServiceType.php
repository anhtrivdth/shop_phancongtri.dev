<?php

class ServiceType extends Model
{
    protected string $table = 'service_types';
    protected array $fillable = ['name', 'slug', 'position', 'is_active'];

    public function active(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE is_active = TRUE ORDER BY position ASC");
        return $stmt->fetchAll();
    }
}

