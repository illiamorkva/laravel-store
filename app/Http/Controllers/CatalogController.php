<?php

namespace App\Http\Controllers;

use App\Components\Pagination;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class CatalogController extends Controller
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
     * Action for the page "Catalogue of products"
     */
    public function actionIndex()
    {
        //List of categories for the left menu
        $categories = $this->categoryRepository->getCategoriesList();

        //List of latest products
        $latestProducts = $this->productRepository->getLatestProducts(12);

        return view('catalog.index',[
            'categories'=>$categories, 'latestProducts'=>$latestProducts
            ]);
    }

    /**
     * Action for the page "Category of products"
     */
    public function actionCategory($categoryId, $page = 1)
    {
        //List of categories for the left menu
        $categories = $this->categoryRepository->getCategoriesList();

        // A list of products in category
        $categoryProducts = $this->productRepository->getProductsListByCategory($categoryId, $page);

        // The total amount of goods (needed for pagination)
        $total = $this->productRepository->getTotalProductsInCategory($categoryId);

        // Create the Pagination object - page
        $pagination = new Pagination($total, $page, ProductRepository::SHOW_BY_DEFAULT, 'page-');

        return view('catalog.category',[
            'categories'=>$categories, 'categoryProducts'=>$categoryProducts,
            'total' => $total, 'pagination' => $pagination,
            'categoryId' => $categoryId
        ]);
    }
}
