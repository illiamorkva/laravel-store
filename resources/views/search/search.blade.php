@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Каталог</h2>
                        <div class="panel-group category-products">
                            <?php foreach ($categories as $categoryItem): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="/category/<?php echo $categoryItem->id;?>">
                                            <?php echo $categoryItem->name;?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <?php if($countSearchedProducts > 0): ?>
                        <h2 class="title text-center">Результат поиска: <?php echo $searchedString; ?></h2>
                        <?php else: ?>
                        <h2 class="title text-center">Результаты не соответсвуют условиям поиска</h2>
                         <?php endif; ?>

                        <?php foreach ($searchedProducts as $product): ?>
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="<?php echo \App\Repositories\ProductRepository::getImage($product->id); ?>" alt="" />
                                        <h2>$<?php echo $product->price; ?></h2>
                                        <p>
                                            <a href="/product/<?php echo $product->id; ?>">
                                                <?php echo $product->name; ?>
                                            </a>
                                        </p>
                                        <a href="/cart/add/<?php echo $product->id; ?>" class="btn btn-default add-to-cart" data-id="<?php echo $product->id; ?>"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                    </div>
                                    <?php if ($product->is_new): ?>
                                    <img src="/images/home/new.png" class="new" alt="" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                    </div><!--features_items-->

                </div>
            </div>
        </div>
    </section>
@endsection