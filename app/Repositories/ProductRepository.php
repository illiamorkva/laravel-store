<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    // Number of products displayed by default
    const SHOW_BY_DEFAULT = 6;

    /**
     * Returns an array of the last products
     * @param type $count [optional] <p>Amount</p>
     * @param type $page [optional] <p>Current page number</p>
     * @return array <p>Array with goods</p>
     */
    public function getLatestProducts($count = self::SHOW_BY_DEFAULT)
    {
        $productsList = Product::where('status', 1)
            ->orderBy('id', 'desc')
            ->take($count)
            ->get(['id', 'name', 'price', 'is_new']);

        return $productsList;
    }

    /**
     * Returns a list of recommended products
     * @return array <p>Array with goods</p>
     */
    public function getRecommendedProducts()
    {
        $productsList = Product::where('status', 1)
            ->where('is_recommended', 1)
            ->orderBy('id', 'desc')
            ->get(['id', 'name', 'price', 'is_new']);

        return $productsList;
    }

    /**
     * Returns the path to the image
     * @param integer $id
     * @return string <p>Image path</p>
     */
    public static function getImage($id)
    {
        // Name of the dummy image
        $noImage = 'no-image.jpg';

        // The path to the folder with the goods
        $path = '/upload/images/products/';

        // The way to the product image
        $pathToProductImage = $path . $id . '.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            return $pathToProductImage;
        }

        return $path . $noImage;
    }
}
