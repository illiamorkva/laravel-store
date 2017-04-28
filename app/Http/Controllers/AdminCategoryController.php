<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    /**
     * Instance CategoryRepository.
     *
     * @var CategoryRepository
     */
    protected $categoryRepository;


    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->middleware(['auth','role:admin']);

        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Action for page "Manage categories"
     */
    public function actionIndex()
    {
        //Get information about categories
        $categoriesList = $this->categoryRepository->getCategoriesListAdmin();

        return view('admin_category.index', [
            'categoriesList' => $categoriesList
        ]);
    }
}
