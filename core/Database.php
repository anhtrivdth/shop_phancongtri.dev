<?php
declare(strict_types=1);

namespace Core;

use PDO;
use PDOException;
use RuntimeException;

require_once __DIR__ . '/Functions.php';

final class Database
{
    private static ?PDO $connection = null;
    private static ?array $config = null;

    public static function getConnection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $config = self::getConfig();
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['dbname'],
            $config['charset']
        );

        try {
            $pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);

            $timezone = $config['timezone'] ?? '+00:00';
            $pdo->exec(sprintf("SET time_zone = '%s'", $timezone));

            self::$connection = $pdo;
            return $pdo;
        } catch (PDOException $exception) {
            Functions::logError('Database connection failed: ' . $exception->getMessage());
            throw new RuntimeException('Unable to connect to database.');
        }
    }

    private static function getConfig(): array
    {
        if (self::$config !== null) {
            return self::$config;
        }

        $configPath = dirname(__DIR__) . '/config/database.php';
        if (!file_exists($configPath)) {
            throw new RuntimeException('Database configuration file missing.');
        }

        $config = require $configPath;
        if (!is_array($config)) {
            throw new RuntimeException('Invalid database configuration.');
        }

        self::$config = $config;
        return $config;
    }
}

