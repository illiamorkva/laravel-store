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

    /**
     * Returns an array of the categories list in the admin panel <br/>
     * (in this case, the result get enabled and disabled category)
     * @return array <p>An array of the categories</p>
     */
    public function getCategoriesListAdmin()
    {
        $categoryList = Category::orderBy('sort_order', 'asc')
            ->get(['id', 'name', 'sort_order', 'status']);

        return $categoryList;
    }

    /**
     * Returns category with specified id
     * @param integer $id <p>Id category</p>
     * @return array <p>Object of information about the category</p>
     */
    public function getCategoryById($id)
    {
        return Category::findOrFail($id);
    }

    /**
     * Returns text explanation of status category :<br/>
     * <i>0 - Hidden, 1 - Displayed</i>
     * @param integer $status <p>Status</p>
     * @return string <p>Text explanation</p>
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Отображается';
                break;
            case '0':
                return 'Скрыта';
                break;
        }
    }
}