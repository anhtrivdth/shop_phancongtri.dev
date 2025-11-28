<?php

class FooterSetting extends Model
{
    protected string $table = 'footer_settings';
    protected array $fillable = ['logo_url', 'description', 'qr_code_url', 'mini_banner_url', 'copyright_text', 'policies', 'quick_links', 'updated_at'];

    public function current(): ?array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY updated_at DESC LIMIT 1");
        $result = $stmt->fetch();
        if ($result) {
            $result['policies'] = json_decode($result['policies'] ?? '[]', true);
            $result['quick_links'] = json_decode($result['quick_links'] ?? '[]', true);
        }
        return $result ?: null;
    }
}

