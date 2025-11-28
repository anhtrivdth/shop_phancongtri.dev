<?php
declare(strict_types=1);

namespace Core;

use PDO;

abstract class Model
{
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function all(string $orderBy = 'id DESC', ?int $limit = null): array
    {
        $query = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        if ($limit !== null) {
            $query .= " LIMIT {$limit}";
        }

        return $this->db->query($query)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $statement = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1"
        );
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();

        return $result ?: null;
    }

    public function findBySlug(string $slug): ?array
    {
        $statement = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE slug = :slug LIMIT 1"
        );
        $statement->execute(['slug' => $slug]);
        $result = $statement->fetch();

        return $result ?: null;
    }

    public function create(array $data): int
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $statement = $this->db->prepare(
            "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})"
        );
        $statement->execute($data);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $set = implode(', ', array_map(static fn ($key) => "{$key} = :{$key}", array_keys($data)));
        $data[$this->primaryKey] = $id;

        $statement = $this->db->prepare(
            "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = :{$this->primaryKey}"
        );

        return $statement->execute($data);
    }

    public function delete(int $id): bool
    {
        $statement = $this->db->prepare(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id"
        );

        return $statement->execute(['id' => $id]);
    }
}

