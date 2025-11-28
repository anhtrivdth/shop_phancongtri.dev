<?php

class AdminReviewController extends AdminBaseController
{
    private Review $review;

    public function __construct()
    {
        $this->review = new Review();
        parent::__construct();
    }

    public function index(): string
    {
        return $this->view('admin/reviews/index', [
            'title' => 'Đánh giá',
            'reviews' => $this->review->all('created_at DESC'),
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function toggle(int $id): void
    {
        $this->guardCsrf();
        $review = $this->review->find($id);
        if ($review) {
            $this->review->update($id, ['is_hidden' => !$review['is_hidden']]);
        }
        $this->redirect("/{$this->appConfig['admin_base']}/reviews");
    }

    public function destroy(int $id): void
    {
        $this->guardCsrf();
        $this->review->delete($id);
        $this->redirect("/{$this->appConfig['admin_base']}/reviews");
    }

    private function guardCsrf(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('CSRF failed');
        }
    }
}

