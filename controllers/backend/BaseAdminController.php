<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Core\Auth;
use Core\Controller;
use PDO;

abstract class BaseAdminController extends Controller
{
    protected Auth $auth;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->auth = new Auth($db);
        $this->auth->requireLogin();
    }
}

