<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Models\Blog;
use Models\CategoryLevel1;
use Models\Product;

class DashboardController extends BaseAdminController
{
    public function index(): void
    {
        $stats = [
            'categories' => (new CategoryLevel1($this->db))->all(),
            'products'   => (new Product($this->db))->all(),
            'blogs'      => (new Blog($this->db))->all(),
        ];

        $this->render('backend/dashboard.php', [
            'stats' => [
                'categories' => count($stats['categories']),
                'products'   => count($stats['products']),
                'blogs'      => count($stats['blogs']),
            ],
        ]);
    }
}

