<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Action for the view page of the product
     */
    public function actionView($productId)
    {
        //List of categories for the left menu
        $categories = $this->categoryRepository->getCategoriesList();

        //Get information about product
        $product = $this->productRepository->getProductById($productId);

        return view('product.view', [
            'categories' => $categories, 'product' => $product
        ]);
    }
}
