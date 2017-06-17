<?php

namespace App\Http\Controllers;

use App\Components\Elastic;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ElasticSearchRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
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

    /**
     * Instance ElasticSearchRepository.
     *
     * @var ElasticSearchRepository
     */
    protected $elasticSearchRepository;


    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository,
                                ElasticSearchRepository $elasticSearchRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->elasticSearchRepository = $elasticSearchRepository;
    }

    /**
     * Action for the page "Search products"
     */
    public function actionSearch(Request $request, Elastic $elastic)
    {
        $countSearchedProducts = 0;
        $searchedProducts = array();
        $searchedString = $request->input('query');

        if(isset($searchedString)) {
            $searchedProducts = $this->elasticSearchRepository->getProductsListByElasticSearch($searchedString, $elastic);
            $countSearchedProducts = count($searchedProducts);
        }

        //List of categories for the left menu
        $categories = $this->categoryRepository->getCategoriesList();

        return view('search.search', [
            'categories'=> $categories, 'searchedProducts'=> $searchedProducts,
            'countSearchedProducts' => $countSearchedProducts, 'searchedString' => $searchedString
        ]);
    }
}
