<?php
declare(strict_types=1);

namespace Models;

class Admin extends BaseModel
{
    protected string $table = 'admins';

    public function findByUsername(string $username): ?array
    {
        $statement = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = :username LIMIT 1");
        $statement->execute(['username' => $username]);
        $result = $statement->fetch();

        return $result ?: null;
    }

    public function ensureDefaultAdmin(): void
    {
        $statement = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $total = (int) ($statement->fetch()['total'] ?? 0);

        if ($total === 0) {
            $this->create([
                'username' => 'admin',
                'password' => password_hash('admin', PASSWORD_BCRYPT),
                'role'     => 1,
            ]);
        }
    }
}

