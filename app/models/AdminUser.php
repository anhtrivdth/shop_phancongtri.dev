<?php

class AdminUser extends Model
{
    protected string $table = 'admin_users';
    protected array $fillable = ['email', 'is_active'];

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}

