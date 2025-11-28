<?php

class AdminSession extends Model
{
    protected string $table = 'admin_sessions';
    protected array $fillable = ['admin_id', 'otp_secret', 'otp_expires_at'];

    public function createOtp(int $adminId, string $otp): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (admin_id, otp_secret, otp_expires_at)
            VALUES (:admin_id, :otp_secret, :otp_expires_at)
        ");
        $expires = (new DateTime('+5 minutes'))->format('Y-m-d H:i:s');
        $stmt->execute([
            'admin_id' => $adminId,
            'otp_secret' => password_hash($otp, PASSWORD_BCRYPT),
            'otp_expires_at' => $expires,
        ]);
    }

    public function validateOtp(int $adminId, string $otp): bool
    {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE admin_id = :admin_id
            ORDER BY issued_at DESC
            LIMIT 1
        ");
        $stmt->execute(['admin_id' => $adminId]);
        $record = $stmt->fetch();
        if (!$record) {
            return false;
        }

        if (new DateTime() > new DateTime($record['otp_expires_at'])) {
            return false;
        }

        return password_verify($otp, $record['otp_secret']);
    }
}

