<?php

class OptionValue extends Model
{
    protected string $table = 'product_option_values';
    protected array $fillable = ['group_id', 'value', 'position'];

    public function forGroup(int $groupId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE group_id = :group_id ORDER BY position ASC");
        $stmt->execute(['group_id' => $groupId]);
        return $stmt->fetchAll();
    }
}

