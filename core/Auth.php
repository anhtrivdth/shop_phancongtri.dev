<?php
declare(strict_types=1);

namespace Core;

use Models\Admin;
use PDO;

class Auth
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function attempt(string $username, string $password): bool
    {
        $adminModel = new Admin($this->db);
        $admin = $adminModel->findByUsername($username);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = [
                'id'       => $admin['id'],
                'username' => $admin['username'],
                'role'     => $admin['role'],
            ];

            return true;
        }

        return false;
    }

    public function logout(): void
    {
        unset($_SESSION['admin']);
        session_regenerate_id(true);
    }

    public function user(): ?array
    {
        return $_SESSION['admin'] ?? null;
    }

    public function check(): bool
    {
        return isset($_SESSION['admin']);
    }

    public function requireLogin(): void
    {
        if (!$this->check()) {
            Functions::redirect('/admin/login');
        }
    }
}

