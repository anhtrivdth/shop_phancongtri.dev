<?php
declare(strict_types=1);

namespace Core;

use Exception;

class Functions
{
    private const MAX_UPLOAD_SIZE = 5242880; // 5MB
    private const ALLOWED_TYPES = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

    public static function view(string $view, array $data = []): void
    {
        $viewPath = dirname(__DIR__) . '/views/' . $view;
        if (!file_exists($viewPath)) {
            self::logError("View not found: {$view}");
            http_response_code(404);
            echo 'View not found.';
            return;
        }

        extract($data, EXTR_SKIP);
        require $viewPath;
    }

    public static function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    public static function sanitize(array|string $value): array|string
    {
        if (is_array($value)) {
            return array_map([self::class, 'sanitize'], $value);
        }

        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    public static function generateSlug(string $value): string
    {
        $value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        $value = preg_replace('/[^a-zA-Z0-9]+/', '-', $value);
        $value = strtolower(trim((string) $value, '-'));

        return $value ?: uniqid();
    }

    public static function flash(string $key, ?string $message = null): ?string
    {
        if ($message === null) {
            if (!isset($_SESSION[$key])) {
                return null;
            }

            $msg = $_SESSION[$key];
            unset($_SESSION[$key]);

            return $msg;
        }

        $_SESSION[$key] = $message;

        return null;
    }

    public static function logError(string $message): void
    {
        $logDirectory = dirname(__DIR__) . '/logs';
        if (!is_dir($logDirectory)) {
            mkdir($logDirectory, 0775, true);
        }

        $entry = sprintf("[%s] %s%s", gmdate('Y-m-d H:i:s'), $message, PHP_EOL);
        file_put_contents($logDirectory . '/error.log', $entry, FILE_APPEND);
    }

    public static function handleUpload(array $file, string $slug): ?string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            self::logError("Upload error code: {$file['error']}");
            throw new Exception('File upload failed.');
        }

        if (($file['size'] ?? 0) > self::MAX_UPLOAD_SIZE) {
            throw new Exception('File exceeds 5MB limit.');
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, self::ALLOWED_TYPES, true)) {
            throw new Exception('Invalid file type.');
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $slug = $slug ?: pathinfo($file['name'], PATHINFO_FILENAME);
        $filename = sprintf('%s-%s.%s', $slug, time(), strtolower($extension));

        $targetDir = dirname(__DIR__) . '/uploads';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        $destination = $targetDir . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception('Unable to move uploaded file.');
        }

        return $filename;
    }
}

namespace {
    use Core\Functions;

    if (!function_exists('view')) {
        function view(string $view, array $data = []): void
        {
            Functions::view($view, $data);
        }
    }

    if (!function_exists('redirect')) {
        function redirect(string $url): void
        {
            Functions::redirect($url);
        }
    }
}

