<?php

namespace App\Http\Controllers;

use App\Components\Elastic;
use App\Models\Product;
use App\Repositories\CategoryRepository;
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


    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Action for the page "Search products"
     */
    public function actionSearch(Request $request, Elastic $elastic)
    {

        $searchString = $request->input('query');

        if(!isset($searchString)){
            $searchString = "";
        }

        $query = [
            'multi_match' => [
                'query' => $searchString,
                'fuzziness' => 'AUTO',
                'fields' => ['name', 'description'],
            ],
        ];

        $parameters = [
            'index' => 'store',
            'type' => 'products',
            'body' => [
                'query' => $query
            ]
        ];

        $response = $elastic->search($parameters);

        /**
         * The data comes in a structure like this:
         *
         * [
         *      'hits' => [
         *          'hits' => [
         *              [ '_source' => 1 ],
         *              [ '_source' => 2 ],
         *          ]
         *      ]
         * ]
         *
         * And we only care about the _source of the documents.
         */

        $sources = array_pluck($response['hits']['hits'], '_source') ?: [];

        //We have to convert the results array into Eloquent Models
        $searchProducts = Product::hydrate($sources);

        //Count searched products
        $total = count($searchProducts);

        //List of categories for the left menu
        $categories = $this->categoryRepository->getCategoriesList();

        return view('search.search', [
            'categories'=> $categories, 'searchProducts'=> $searchProducts,
            'total' => $total, 'searchString' => $searchString
        ]);
    }
}
