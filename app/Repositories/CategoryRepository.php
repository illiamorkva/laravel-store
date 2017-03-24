<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    /**
     * Returns an array of categories for the list on the site
     * @return array <p>Array with categories</p>
     */
    public function getCategoriesList()
    {
        $categoryList = Category::where('status', 1)
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);

        return $categoryList;
    }
}