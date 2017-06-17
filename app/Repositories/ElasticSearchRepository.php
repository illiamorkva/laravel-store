<?php

namespace App\Repositories;

use App\Models\Product;

class ElasticSearchRepository
{
    // Number of products by default
    const SHOW_BY_DEFAULT = 12;

    /**
     * Returns a list of products
     * @param type $searchedString <p>Searched string</p>
     * @param type $elastic <p>Elastic</p>
     * @return type <p>An array of goods</p>
     */
    public function getProductsListByElasticSearch($searchedString, $elastic)
    {
        $query = [
            'multi_match' => [
                'query' => $searchedString,
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
        $searchedProducts = Product::hydrate($sources);

        return $searchedProducts;
    }
}