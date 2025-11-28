<?php

class SiteSetting extends Model
{
    protected string $table = 'site_settings';
    protected array $fillable = ['dark_mode_default', 'hero_search_placeholder', 'admin_base_path'];

    public function current(): ?array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY updated_at DESC LIMIT 1");
        return $stmt->fetch() ?: null;
    }
}

