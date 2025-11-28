<?php
declare(strict_types=1);

namespace Controllers\Backend;

use Core\Functions;
use Models\Product;

class CsvController extends BaseAdminController
{
    private Product $productModel;

    public function __construct(\PDO $db)
    {
        parent::__construct($db);
        $this->productModel = new Product($db);
    }

    public function index(): void
    {
        $this->render('backend/csv/index.php', [
            'success' => Functions::flash('success'),
            'error'   => Functions::flash('error'),
        ]);
    }

    public function import(): void
    {
        if (empty($_FILES['csv_file']['tmp_name'])) {
            Functions::flash('error', 'CSV file is required.');
            $this->redirect('/admin/csv-import');
        }

        $file = $_FILES['csv_file']['tmp_name'];
        $handle = fopen($file, 'r');

        if ($handle === false) {
            Functions::flash('error', 'Unable to read file.');
            $this->redirect('/admin/csv-import');
        }

        $header = fgetcsv($handle);
        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            $name = Functions::sanitize($data['name'] ?? '');
            if ($name === '') {
                continue;
            }

            $slug = $data['slug'] ?: Functions::generateSlug($name);

            $this->productModel->create([
                'lvl2_id'    => (int) ($data['lvl2_id'] ?? 0),
                'name'       => $name,
                'slug'       => $slug,
                'description'=> $data['description'] ?? '',
                'thumbnail'  => null,
                'status'     => (int) ($data['status'] ?? 1),
                'views'      => 0,
                'created_at' => gmdate('Y-m-d H:i:s'),
            ]);

            $count++;
        }

        fclose($handle);

        Functions::flash('success', "{$count} products imported.");
        $this->redirect('/admin/csv-import');
    }
}

