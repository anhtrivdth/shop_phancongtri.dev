<?php

class View
{
    public static function render(string $template, array $data = []): string
    {
        $viewPath = dirname(__DIR__) . '/app/views/' . $template . '.php';
        if (!file_exists($viewPath)) {
            throw new RuntimeException("View {$template} not found.");
        }

        extract($data);
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }
}

