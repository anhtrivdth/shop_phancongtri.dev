<?php
declare(strict_types=1);

use Core\Database;
use PDO;
use Throwable;

require_once __DIR__ . '/Functions.php';

spl_autoload_register(static function (string $class): void {
    $baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR;
    $prefixes = [
        'Core\\'        => 'core/',
        'Controllers\\' => 'controllers/',
        'Models\\'      => 'models/',
    ];

    foreach ($prefixes as $prefix => $directory) {
        if (str_starts_with($class, $prefix)) {
            $relative = substr($class, strlen($prefix));
            $file = $baseDir . $directory . str_replace('\\', '/', $relative) . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
            return;
        }
    }
});

final class MigrationRunner
{
    private PDO $db;
    private string $schemaPath;
    private string $logPath;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->schemaPath = dirname(__DIR__) . '/database/schema.sql';
        $this->logPath = dirname(__DIR__) . '/logs/migrations.log';
    }

    public function run(bool $fresh = false): void
    {
        if (!file_exists($this->schemaPath)) {
            $this->log('Schema file missing at ' . $this->schemaPath);
            throw new RuntimeException('Schema file not found.');
        }

        $sql = file_get_contents($this->schemaPath);
        if ($sql === false) {
            throw new RuntimeException('Unable to read schema file.');
        }

        $this->log('Migration started' . ($fresh ? ' (fresh mode)' : ''));

        try {
            $this->db->beginTransaction();

            if ($fresh) {
                $this->db->exec('SET FOREIGN_KEY_CHECKS = 0');
            }

            $this->executeStatements($sql);

            if ($fresh) {
                $this->db->exec('SET FOREIGN_KEY_CHECKS = 1');
            }

            $this->seedDefaultAdmin();

            $this->db->commit();
            $this->log('Migration completed successfully');
            echo "Migration completed.\n";
        } catch (Throwable $throwable) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            $this->log('Migration failed: ' . $throwable->getMessage());
            throw $throwable;
        }
    }

    private function executeStatements(string $sql): void
    {
        $statements = preg_split('/;(?=(?:[^\'"]|\'[^\']*\'|"[^"]*")*$)/', $sql);
        if ($statements === false) {
            throw new RuntimeException('Failed to parse schema statements.');
        }

        foreach ($statements as $statement) {
            $trimmed = trim($statement);
            if ($trimmed === '') {
                continue;
            }
            $this->db->exec($trimmed);
        }
    }

    private function seedDefaultAdmin(): void
    {
        $statement = $this->db->prepare('SELECT COUNT(*) AS total FROM admins WHERE username = :username');
        $statement->execute(['username' => 'admin']);
        $total = (int) ($statement->fetch()['total'] ?? 0);

        if ($total > 0) {
            return;
        }

        $insert = $this->db->prepare(
            'INSERT INTO admins (username, password, role) VALUES (:username, :password, :role)'
        );

        $insert->execute([
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_BCRYPT),
            'role'     => 1,
        ]);

        $this->log('Default admin seeded.');
    }

    private function log(string $message): void
    {
        $directory = dirname($this->logPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $entry = sprintf("[%s] %s%s", gmdate('Y-m-d H:i:s'), $message, PHP_EOL);
        file_put_contents($this->logPath, $entry, FILE_APPEND);
    }
}

$fresh = in_array('--fresh', $argv, true) || in_array('-f', $argv, true);

try {
    (new MigrationRunner())->run($fresh);
} catch (Throwable $throwable) {
    echo 'Migration failed: ' . $throwable->getMessage() . PHP_EOL;
    exit(1);
}

