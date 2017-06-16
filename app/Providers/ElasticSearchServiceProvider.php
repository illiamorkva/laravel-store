<?php

namespace App\Providers;

use App\Models\Product;
use App\Components\Elastic;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class ElasticSearchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $elastic = $this->app->make(Elastic::class);

        Product::saved(function ($product) use ($elastic) {
            $elastic->index([
                'index' => 'store',
                'type' => 'products',
                'id' => $product->id,
                'body' => $product->toArray()
            ]);
        });

        Product::deleted(function ($product) use ($elastic) {
            $elastic->delete([
                'index' => 'store',
                'type' => 'products',
                'id' => $product->id,
            ]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Elastic::class, function ($app) {
            return new Elastic(
                ClientBuilder::create()
                    ->setLogger(ClientBuilder::defaultLogger(storage_path('logs/elastic.log')))
                    ->build()
            );
        });
    }
}
