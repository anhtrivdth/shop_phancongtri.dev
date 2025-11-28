<?php
declare(strict_types=1);

namespace Models;

class Blog extends BaseModel
{
    protected string $table = 'blogs';

    public function latest(int $limit = 10): array
    {
        return $this->all('created_at DESC', $limit);
    }

    public function findBySlugWithCategory(string $slug): ?array
    {
        $query = "SELECT b.*, bc.name AS category_name
                  FROM {$this->table} b
                  INNER JOIN blog_categories bc ON bc.id = b.category_id
                  WHERE b.slug = :slug LIMIT 1";
        $statement = $this->db->prepare($query);
        $statement->execute(['slug' => $slug]);
        $result = $statement->fetch();

        return $result ?: null;
    }

    public function related(int $categoryId, int $excludeId, int $limit = 3): array
    {
        $query = "SELECT * FROM {$this->table}
                  WHERE category_id = :category_id AND id <> :exclude_id
                  ORDER BY created_at DESC LIMIT :limit";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':category_id', $categoryId, \PDO::PARAM_INT);
        $statement->bindValue(':exclude_id', $excludeId, \PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}

