<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

    /**
     * Action for page "Add category"
     */
    public function actionCreate(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'name' => 'required',
                'sort_order' => 'required|min:1|numeric',
            ]);

            $category = new Category();
            $category->name = $request->input('name');
            $category->sort_order = $request->input('sort_order');
            $category->status = $request->input('status');
            $category->save();

            return redirect("admin/category");
        }
        return view('admin_category.create');
    }
}
