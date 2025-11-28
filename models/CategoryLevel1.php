<?php
declare(strict_types=1);

namespace Models;

class CategoryLevel1 extends BaseModel
{
    protected string $table = 'categories_lvl1';

    public function getAllWithChildren(CategoryLevel2 $lvl2Model): array
    {
        $categories = $this->all('created_at DESC');
        foreach ($categories as &$category) {
            $category['children'] = $lvl2Model->getByLevel1((int) $category['id']);
        }

        return $categories;
    }
}

