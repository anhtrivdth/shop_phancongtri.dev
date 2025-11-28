<?php
declare(strict_types=1);

namespace Core;

use PDO;

abstract class Controller
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    protected function render(string $view, array $data = []): void
    {
        Functions::view($view, $data);
    }

    protected function redirect(string $url): void
    {
        Functions::redirect($url);
    }

    protected function validate(array $rules, array $input): array
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $value = $input[$field] ?? null;

            foreach (explode('|', $rule) as $constraint) {
                if ($constraint === 'required' && (empty($value) && $value !== '0')) {
                    $errors[$field][] = 'This field is required.';
                }

                if ($constraint === 'slug' && !empty($value) && !preg_match('/^[a-z0-9-]+$/', $value)) {
                    $errors[$field][] = 'Invalid slug format.';
                }
            }
        }

        return $errors;
    }

    protected function handleUpload(array $file, string $slug): ?string
    {
        return Functions::handleUpload($file, $slug);
    }
}

