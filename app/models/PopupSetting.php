<?php

class PopupSetting extends Model
{
    protected string $table = 'popup_settings';
    protected array $fillable = ['is_enabled', 'image_url', 'title', 'body', 'action_label', 'action_url'];

    public function active(): ?array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE is_enabled = TRUE ORDER BY updated_at DESC LIMIT 1");
        $result = $stmt->fetch();
        return $result ?: null;
    }
}

