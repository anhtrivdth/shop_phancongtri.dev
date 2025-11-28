<?php
declare(strict_types=1);

namespace Controllers\Frontend;

use Core\Controller;
use Core\Functions;
use Models\CategoryLevel1;
use Models\CategoryLevel2;
use Models\Product;

class HomeController extends Controller
{
    public function index(): void
    {
        $categoryLvl1Model = new CategoryLevel1($this->db);
        $categoryLvl2Model = new CategoryLevel2($this->db);
        $productModel = new Product($this->db);

        $data = [
            'categoriesLvl1' => $categoryLvl1Model->getAllWithChildren($categoryLvl2Model),
            'categoriesLvl2' => $categoryLvl2Model->all('created_at DESC'),
            'latestProducts' => $productModel->latest(8),
            'flash'          => [
                'success' => Functions::flash('success'),
                'error'   => Functions::flash('error'),
            ],
        ];

        $this->render('frontend/home.php', $data);
    }
}

