<?php
declare(strict_types=1);

namespace Core;

use PDO;
use Throwable;

class Router
{
    private PDO $db;

    /**
     * @var array<string, array<string, string>>
     */
    private array $routes = [
        'GET'  => [],
        'POST' => [],
    ];

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function get(string $path, string $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, string $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    public function dispatch(string $uri, string $method): void
    {
        $method = strtoupper($method);
        $uri = $this->normalize($uri);

        $handler = $this->routes[$method][$uri] ?? null;
        if ($handler === null) {
            http_response_code(404);
            echo '404 - Page not found';
            return;
        }

        [$controllerName, $action] = explode('@', $handler);

        if (!class_exists($controllerName)) {
            Functions::logError("Controller not found: {$controllerName}");
            http_response_code(500);
            echo 'Controller not found.';
            return;
        }

        $controller = new $controllerName($this->db);
        if (!method_exists($controller, $action)) {
            Functions::logError("Action {$action} missing in {$controllerName}");
            http_response_code(500);
            echo 'Action not implemented.';
            return;
        }

        try {
            $controller->{$action}();
        } catch (Throwable $throwable) {
            Functions::logError($throwable->getMessage());
            http_response_code(500);
            echo 'Something went wrong.';
        }
    }

    private function addRoute(string $method, string $path, string $handler): void
    {
        $method = strtoupper($method);
        $path = $this->normalize($path);
        $this->routes[$method][$path] = $handler;
    }

    private function normalize(string $uri): string
    {
        $normalized = rtrim($uri, '/');
        if ($normalized === '') {
            return '/';
        }

        return $normalized;
    }
}

