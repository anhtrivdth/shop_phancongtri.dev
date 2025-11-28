<?php
declare(strict_types=1);

namespace Models;

class CategoryLevel2 extends BaseModel
{
    protected string $table = 'categories_lvl2';

    public function getByLevel1(int $level1Id): array
    {
        $statement = $this->db->prepare("SELECT * FROM {$this->table} WHERE lvl1_id = :lvl1_id ORDER BY created_at DESC");
        $statement->execute(['lvl1_id' => $level1Id]);

        return $statement->fetchAll();
    }

    public function findBySlugWithParent(string $slug): ?array
    {
        $query = "SELECT c2.*, c1.name AS parent_name, c1.slug AS parent_slug
                  FROM {$this->table} c2
                  INNER JOIN categories_lvl1 c1 ON c1.id = c2.lvl1_id
                  WHERE c2.slug = :slug LIMIT 1";
        $statement = $this->db->prepare($query);
        $statement->execute(['slug' => $slug]);
        $result = $statement->fetch();

        return $result ?: null;
    }
}

