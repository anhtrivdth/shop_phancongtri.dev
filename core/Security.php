<?php

class Security
{
    public static function csrfToken(): string
    {
        Session::start();
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['_csrf_time'] = time();
        }
        return $_SESSION['_csrf_token'];
    }

    public static function validateCsrf(?string $token): bool
    {
        Session::start();
        $config = require dirname(__DIR__) . '/config/app.php';
        $storedToken = $_SESSION['_csrf_token'] ?? null;
        $issuedAt = $_SESSION['_csrf_time'] ?? 0;
        $valid = hash_equals((string)$storedToken, (string)$token) && (time() - $issuedAt) <= $config['csrf_token_lifetime'];
        if ($valid) {
            unset($_SESSION['_csrf_token'], $_SESSION['_csrf_time']);
        }
        return $valid;
    }

    public static function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}

