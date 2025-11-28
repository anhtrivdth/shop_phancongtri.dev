<?php

class Router
{
    private array $routes = [];
    private string $basePath;

    public function __construct(string $basePath = '/')
    {
        $this->basePath = rtrim($basePath, '/') ?: '/';
    }

    public function add(string $method, string $pattern, callable $callback): void
    {
        $method = strtoupper($method);
        $pattern = '#^' . preg_replace('#\{([a-zA-Z0-9_]+)\}#', '(?P<$1>[^/]+)', $pattern) . '$#';
        $this->routes[$method][] = ['pattern' => $pattern, 'callback' => $callback];
    }

    public function dispatch(string $method, string $uri)
    {
        $method = strtoupper($method);
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        if ($this->basePath !== '/' && str_starts_with($path, $this->basePath)) {
            $path = substr($path, strlen($this->basePath));
        }
        $path = '/' . ltrim($path, '/');
        $path = $path === '/' ? '/' : '/' . trim($path, '/');

        foreach ($this->routes[$method] ?? [] as $route) {
            if (preg_match($route['pattern'], $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return call_user_func_array($route['callback'], $params);
            }
        }

        http_response_code(404);
        echo View::render('frontend/404', ['title' => 'Page Not Found']);
        return null;
    }
}

