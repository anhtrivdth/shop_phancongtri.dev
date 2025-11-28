<?php
declare(strict_types=1);

namespace Config;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = self::createConnection();
        }

        return self::$instance;
    }

    private static function createConnection(): PDO
    {
        $dsn = 'mysql:host=localhost;dbname=myshop;charset=utf8mb4';

        try {
            $pdo = new PDO($dsn, 'root', '', [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);

            $pdo->exec("SET time_zone = '+00:00'");

            return $pdo;
        } catch (PDOException $exception) {
            $message = sprintf('Database connection failed: %s', $exception->getMessage());
            $logPath = dirname(__DIR__) . '/logs/error.log';
            $entry = sprintf("[%s] %s%s", gmdate('Y-m-d H:i:s'), $message, PHP_EOL);
            file_put_contents($logPath, $entry, FILE_APPEND);
            http_response_code(500);
            exit('Database connection error.');
        }
    }
}

