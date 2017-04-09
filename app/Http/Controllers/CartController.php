<?php

namespace App\Http\Controllers;

use App\Components\Cart;
use App\Models\Order;
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

    /**
     * Action for the page "Checkout"
     */
    public function actionCheckout(Request $request)
    {
        // Get data from basket
        $productsInCart = Cart::getProducts();

        if ($productsInCart == false) {
            return redirect("/");
        }

        // List of categories for left menu
        $categories = $this->categoryRepository->getCategoriesList();

        // Find the total cost
        $productsIds = array_keys($productsInCart);
        $products = $this->productRepository->getProductsByIds($productsIds);
        $totalPrice = Cart::getTotalPrice($products);

        $totalQuantity = Cart::countItems();

        // The fields for the form
        $userName = false;

        // Status successful checkout
        $result = false;

        // Check if the user is a guest
        if ($request->user()) {
            $userId = $request->user()->id;
            $userName = $request->user()->name;
        } else {
            $userId = false;
        }

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'userName' => 'required|min:2',
                'userPhone' => 'required|min:10',
            ]);

            $userName = $request->input('userName');
            $userPhone = $request->input('userPhone');
            $userComment = $request->input('userComment');
            $products = json_encode($productsInCart);

            $order = new Order();
            $order->user_name = $userName;
            $order->user_phone = $userPhone;
            $order->user_comment = $userComment;
            $order->user_id = $userId;
            $order->products = $products;

            $result = $order->save();

            if ($result) {
                $adminEmail = 'illia@morkva.name';
                $message = '<a href="http://store-laravel.local/admin/orders">Список заказов</a>';
                $subject = 'Новый заказ!';
                //  mail($adminEmail, $subject, $message);
                Cart::clear();
            }
        }
        return view('cart.checkout', [
            'categories' => $categories, 'result' => $result,
            'totalQuantity' => $totalQuantity, 'totalPrice'=> $totalPrice,
            'userName' => $userName
        ]);
    }
}

