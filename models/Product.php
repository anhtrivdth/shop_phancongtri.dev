<?php
declare(strict_types=1);

namespace Models;

class Product extends BaseModel
{
    protected string $table = 'products';

    public function latest(int $limit = 8): array
    {
        return $this->all('created_at DESC', $limit);
    }

    public function getByCategory(int $lvl2Id, int $limit = 20, int $offset = 0): array
    {
        $statement = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE lvl2_id = :lvl2_id ORDER BY created_at DESC LIMIT :limit OFFSET :offset"
        );
        $statement->bindValue(':lvl2_id', $lvl2Id, \PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function findWithRelations(string $slug): ?array
    {
        $query = "SELECT p.*, c2.name AS category_name, c2.slug AS category_slug
                  FROM {$this->table} p
                  INNER JOIN categories_lvl2 c2 ON c2.id = p.lvl2_id
                  WHERE p.slug = :slug LIMIT 1";
        $statement = $this->db->prepare($query);
        $statement->execute(['slug' => $slug]);
        $result = $statement->fetch();

        return $result ?: null;
    }

    public function incrementViews(int $productId): void
    {
        $statement = $this->db->prepare("UPDATE {$this->table} SET views = views + 1 WHERE id = :id");
        $statement->execute(['id' => $productId]);
    }
}

