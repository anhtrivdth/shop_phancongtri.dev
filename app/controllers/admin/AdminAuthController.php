<?php

class AdminAuthController extends Controller
{
    private AdminUser $adminUser;
    private AdminSession $adminSession;

    public function __construct()
    {
        parent::__construct();
        $this->adminUser = new AdminUser();
        $this->adminSession = new AdminSession();
    }

    public function showLogin(): string
    {
        return $this->view('admin/auth/login', [
            'title' => 'Admin Login',
            'csrf' => Security::csrfToken(),
            'message' => Session::get('otp_message'),
        ]);
    }

    public function requestOtp(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('Invalid CSRF');
        }

        $email = Security::sanitize($_POST['email'] ?? '');
        $user = $this->adminUser->findByEmail($email);
        if (!$user || !$user['is_active']) {
            Session::put('otp_message', 'Email không hợp lệ');
            $this->redirect("/{$this->appConfig['admin_base']}/login");
        }

        $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->adminSession->createOtp($user['id'], $otp);
        Session::put('pending_admin_id', $user['id']);
        Session::put('otp_hint', $otp); // demo only; replace with email integration
        Session::put('otp_message', 'OTP đã được gửi. Mã tạm thời: ' . $otp);

        $this->redirect("/{$this->appConfig['admin_base']}/login");
    }

    public function verifyOtp(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('Invalid CSRF');
        }

        $otp = trim($_POST['otp'] ?? '');
        $adminId = Session::get('pending_admin_id');
        if (!$adminId) {
            Session::put('otp_message', 'Yêu cầu OTP trước.');
            $this->redirect("/{$this->appConfig['admin_base']}/login");
        }

        if ($this->adminSession->validateOtp($adminId, $otp)) {
            Session::put('admin_id', $adminId);
            Session::put('admin_email', $this->adminUser->find($adminId)['email'] ?? 'admin');
            Session::forget('pending_admin_id');
            Session::forget('otp_hint');
            Session::put('otp_message', null);
            $this->redirect("/{$this->appConfig['admin_base']}/dashboard");
        }

        Session::put('otp_message', 'OTP không hợp lệ hoặc đã hết hạn.');
        $this->redirect("/{$this->appConfig['admin_base']}/login");
    }

    public function logout(): void
    {
        Session::forget('admin_id');
        $this->redirect("/{$this->appConfig['admin_base']}/login");
    }
}

