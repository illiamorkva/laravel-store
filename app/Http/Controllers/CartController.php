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

    /**
     * Action to remove the item from your cart
     * @param integer $id <p>id product</p>
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function actionDelete($id)
    {
        Cart::deleteProduct($id);

        return redirect("/cart");
    }

    /**
     * Action for the page "Shopping Cart"
     */
    public function actionIndex()
    {
        // List of categories for left menu
        $categories = $this->categoryRepository->getCategoriesList();

        // Get the IDs and number of items in the cart
        $productsInCart = Cart::getProducts();

        $products = null;
        $totalPrice = 0;

        if ($productsInCart) {
            $productsIds = array_keys($productsInCart);
            $products = $this->productRepository->getProductsByIds($productsIds);
            $totalPrice = Cart::getTotalPrice($products);
        }

        return view('cart.index', [
            'categories' => $categories, 'products' => $products, 'totalPrice' => $totalPrice,
            'productsInCart' => $productsInCart
        ]);
    }




}
