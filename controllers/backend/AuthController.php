<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Core\Auth;
use Core\Controller;
use Core\Functions;
use PDO;

class AuthController extends Controller
{
    private Auth $auth;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->auth = new Auth($db);
    }

    public function index(): void
    {
        if ($this->auth->check()) {
            $this->redirect('/admin/dashboard');
        }

        $this->render('backend/login.php', [
            'error' => Functions::flash('error'),
        ]);
    }

    public function login(): void
    {
        $input = Functions::sanitize($_POST);
        $username = $input['username'] ?? '';
        $password = $input['password'] ?? '';

        if ($this->auth->attempt($username, $password)) {
            Functions::flash('success', 'Logged in successfully.');
            $this->redirect('/admin/dashboard');
        }

        Functions::flash('error', 'Invalid credentials.');
        $this->redirect('/admin/login');
    }

    public function logout(): void
    {
        $this->auth->logout();
        $this->redirect('/admin/login');
    }
}

