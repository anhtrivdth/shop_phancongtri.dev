<?php

abstract class Controller
{
    protected array $appConfig;

    public function __construct()
    {
        $this->appConfig = require dirname(__DIR__) . '/config/app.php';
        date_default_timezone_set($this->appConfig['timezone']);
        $setting = (new SiteSetting())->current();
        if ($setting && !empty($setting['admin_base_path'])) {
            $this->appConfig['admin_base'] = $setting['admin_base_path'];
        }
    }

    protected function view(string $template, array $data = []): string
    {
        return View::render($template, $data);
    }

    protected function redirect(string $path): void
    {
        header("Location: {$path}");
        exit;
    }
}

