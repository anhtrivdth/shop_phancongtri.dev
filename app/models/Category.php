<?php

class Category extends Model
{
    protected string $table = 'categories';
    protected array $fillable = ['service_type_id', 'name', 'slug', 'is_active', 'position'];

    public function byServiceType(int $serviceTypeId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE service_type_id = :service_type_id AND is_active = TRUE ORDER BY position ASC");
        $stmt->execute(['service_type_id' => $serviceTypeId]);
        return $stmt->fetchAll();
    }
}

