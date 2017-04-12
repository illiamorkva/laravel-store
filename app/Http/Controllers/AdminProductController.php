<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Instance CategoryRepository.
     *
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * Instance ProductRepository.
     *
     * @var ProductRepository
     */
    protected $productRepository;


    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository)
    {
        $this->middleware(['auth','role:admin']);

        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Action for page "Manage products"
     */
    public function actionIndex()
    {
        //Get information about products
        $productsList = $this->productRepository->getProductsList();

        return view('admin_product.index', [
             'productsList' => $productsList
        ]);
    }
}
