<?php

namespace App\Components;
use Illuminate\Support\Facades\Session;

/**
 * Class Cart
 * Component basket
 */
class Cart
{

    /**
     * Add to cart (session)
     * @param int $id <p>id product</p>
     * @return integer <p>The number of items in the cart</p>
     */
    public static function addProduct($id)
    {
        $id = intval($id);

        $productsInCart = array();

        if (Session::has('products')) {
            $productsInCart = Session::get('products');
        }

        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id] ++;
        } else {
            $productsInCart[$id] = 1;
        }

        Session::put('products', $productsInCart);

        return self::countItems();
    }

    /**
     * Counting the number of items in the cart (session)
     * @return int <p>The number of items in the cart</p>
     */
    public static function countItems()
    {
        if (Session::has('products')) {
            $count = 0;
            foreach (Session::get('products') as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    /**
     * Returns an array of the id's and number of items in the cart<br/>
     * If there are no goods, return false;
     * @return mixed: boolean or array
     */
    public static function getProducts()
    {
        if (Session::has('products')) {
            return Session::get('products');
        }
        return false;
    }

    /**
     * We obtain the total cost of the transferred goods
     * @param array $products <p>An array of information about products</p>
     * @return integer <p>The total cost</p>
     */
    public static function getTotalPrice($products)
    {
        $productsInCart = self::getProducts();

        $total = 0;
        if ($productsInCart) {
            foreach ($products as $item) {
                $total += $item->price * $productsInCart[$item->id];
            }
        }

        return $total;
    }

    /**
     * Empties basket
     */
    public static function clear()
    {
        if (Session::has('products')) {
            Session::forget('products');;
        }
    }

    /**
     * Removes the item with the specified id from the basket
     * @param integer $id <p>id product</p>
     */
    public static function deleteProduct($id)
    {
        $productsInCart = self::getProducts();

        unset($productsInCart[$id]);

        Session::put('products', $productsInCart);
    }

}
