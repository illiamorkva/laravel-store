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
     * Returns a list of products in the specified category
     * @param type $categoryId <p>id category</p>
     * @param type $page [optional] <p>The page number</p>
     * @return type <p>An array of goods</p>
     */
    public function getProductsListByCategory($categoryId, $page = 1)
    {
        $limit = self::SHOW_BY_DEFAULT;
        // The offset (to request)
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $products = Product::where('status', 1)
            ->where('category_id', $categoryId)
            ->orderBy('id', 'asc')
            ->take($limit)
            ->skip($offset)
            ->get(['id', 'name', 'price', 'is_new']);

        return $products;
    }

    /**
     * Returns product with specified id
     * @param integer $id <p>Id product</p>
     * @return array <p>Object of information about the product</p>
     */
    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    /**
     * Return the number of items in the specified category
     * @param integer $categoryId
     * @return integer
     */
    public function getTotalProductsInCategory($categoryId)
    {
        return Product::where('status', 1)
            ->where('category_id', $categoryId)
            ->count();
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
     * Returns text explanation of the availability of goods:<br/>
     * <i>0 - Under the order, 1 - In stock</i>
     * @param integer $availability <p>Status</p>
     * @return string <p>Text description</p>
     */
    public static function getAvailabilityText($availability)
    {
        switch ($availability) {
            case '1':
                return 'В наличии';
                break;
            case '0':
                return 'Под заказ';
                break;
        }
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
