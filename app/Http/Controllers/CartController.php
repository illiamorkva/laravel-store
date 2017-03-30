<?php

namespace App\Http\Controllers;

use App\Components\Cart;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class CartController extends Controller
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
     * Action to add a product to cart synchronous request<br/>
     * (for example, are not used)
     */
    public function actionAdd(Request $request, $id)
    {
        Cart::addProduct($id);

        $referrer = $request->server('HTTP_REFERER');
        return redirect($referrer);
    }

    /**
     * Action to add a product to the cart using an asynchronous request (ajax)
     * @param integer $id <p>id product</p>
     */
    public function actionAddAjax($id)
    {
        echo Cart::addProduct($id);
    }




}
