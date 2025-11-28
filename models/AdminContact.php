<?php
declare(strict_types=1);

namespace Models;

class AdminContact extends BaseModel
{
    protected string $table = 'admin_contacts';

    public function getByAdmin(int $adminId): ?array
    {
        $statement = $this->db->prepare("SELECT * FROM {$this->table} WHERE admin_id = :admin_id LIMIT 1");
        $statement->execute(['admin_id' => $adminId]);
        $result = $statement->fetch();

        return $result ?: null;
    }
}

