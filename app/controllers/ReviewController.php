<?php

class ReviewController extends Controller
{
    private Review $review;

    public function __construct()
    {
        parent::__construct();
        $this->review = new Review();
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('Invalid CSRF token');
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        if (!$this->review->canPost($ip)) {
            http_response_code(429);
            exit('Please wait before posting another review.');
        }

        $data = [
            'product_id' => (int)($_POST['product_id'] ?? 0),
            'nickname' => Security::sanitize($_POST['nickname'] ?? 'Ẩn danh'),
            'rating' => (int)($_POST['rating'] ?? 0),
            'content' => Security::sanitize($_POST['content'] ?? ''),
            'ip_address' => $ip,
            'is_hidden' => false,
        ];

        if ($data['product_id'] && $data['content']) {
            $this->review->create($data);
        }

        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
    }
}

