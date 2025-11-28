<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Core\Functions;
use Models\Admin;
use Models\AdminContact;

class AdminContactsController extends BaseAdminController
{
    private AdminContact $model;
    private Admin $adminModel;

    public function __construct(\PDO $db)
    {
        parent::__construct($db);
        $this->model = new AdminContact($db);
        $this->adminModel = new Admin($db);
    }

    public function index(): void
    {
        $contacts = $this->model->all('id DESC');
        $admins = $this->adminModel->all('username ASC');

        $this->render('backend/admin_contacts/index.php', [
            'contacts' => $contacts,
            'admins'   => $admins,
        ]);
    }

    public function store(): void
    {
        $input = Functions::sanitize($_POST);
        $this->model->create([
            'admin_id'  => (int) $input['admin_id'],
            'zalo'      => $input['zalo'] ?? null,
            'messenger' => $input['messenger'] ?? null,
            'telegram'  => $input['telegram'] ?? null,
            'discord'   => $input['discord'] ?? null,
            'email'     => $input['email'] ?? null,
            'phone'     => $input['phone'] ?? null,
        ]);

        Functions::flash('success', 'Contact saved.');
        $this->redirect('/admin/admin-contacts');
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $input = Functions::sanitize($_POST);

        $this->model->update($id, [
            'admin_id'  => (int) $input['admin_id'],
            'zalo'      => $input['zalo'] ?? null,
            'messenger' => $input['messenger'] ?? null,
            'telegram'  => $input['telegram'] ?? null,
            'discord'   => $input['discord'] ?? null,
            'email'     => $input['email'] ?? null,
            'phone'     => $input['phone'] ?? null,
        ]);

        Functions::flash('success', 'Contact updated.');
        $this->redirect('/admin/admin-contacts');
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->model->delete($id);
        Functions::flash('success', 'Contact removed.');
        $this->redirect('/admin/admin-contacts');
    }
}

