<?php

return [
    'name' => 'Shop Accounts',
    'environment' => getenv('APP_ENV') ?: 'production',
    'debug' => getenv('APP_DEBUG') === 'true',
    'base_url' => getenv('APP_URL') ?: 'http://localhost',
    'timezone' => 'UTC',
    'admin_base' => getenv('ADMIN_BASE') ?: 'admin',
    'session_name' => 'shop_session',
    'csrf_token_lifetime' => 3600,
    'otp_window' => 300,
    'assets_path' => '/assets',
];

