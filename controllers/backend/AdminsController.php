<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Core\Functions;
use Models\Admin;

class AdminsController extends BaseAdminController
{
    private Admin $model;

    public function __construct(\PDO $db)
    {
        parent::__construct($db);
        $this->model = new Admin($db);
    }

    public function index(): void
    {
        $this->render('backend/admins/index.php', [
            'admins'  => $this->model->all('id DESC'),
            'success' => Functions::flash('success'),
            'error'   => Functions::flash('error'),
        ]);
    }

    public function store(): void
    {
        $input = Functions::sanitize($_POST);
        $password = password_hash($input['password'], PASSWORD_BCRYPT);

        $this->model->create([
            'username' => $input['username'],
            'password' => $password,
            'role'     => (int) ($input['role'] ?? 0),
        ]);

        Functions::flash('success', 'Admin created.');
        $this->redirect('/admin/admins');
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $admin = $this->model->find($id);

        if (!$admin) {
            Functions::flash('error', 'Admin not found.');
            $this->redirect('/admin/admins');
        }

        $data = [
            'username' => $_POST['username'],
            'role'     => (int) ($_POST['role'] ?? 0),
        ];

        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }

        $this->model->update($id, $data);

        Functions::flash('success', 'Admin updated.');
        $this->redirect('/admin/admins');
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->model->delete($id);
        Functions::flash('success', 'Admin deleted.');
        $this->redirect('/admin/admins');
    }
}

