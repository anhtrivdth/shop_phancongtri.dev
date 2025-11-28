<?php

class BlogPost extends Model
{
    protected string $table = 'blog_posts';
    protected array $fillable = ['title', 'slug', 'cover_image', 'excerpt', 'content', 'is_visible', 'published_at'];

    public function latest(int $limit = 4): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE is_visible = TRUE ORDER BY published_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

