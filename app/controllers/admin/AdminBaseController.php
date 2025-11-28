<?php

abstract class AdminBaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->guard();
    }

    protected function guard(): void
    {
        Session::start();
        if (!Session::get('admin_id')) {
            $this->redirect("/{$this->appConfig['admin_base']}/login");
        }
    }
}

