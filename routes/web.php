<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//Auth
Auth::routes();
//Product
Route::match(['get', 'post'], 'product/{id}', 'ProductController@actionView')->where('id', '[0-9]+');
//Catalog
Route::match(['get', 'post'], 'catalog', 'CatalogController@actionIndex');
//Category products
Route::match(['get', 'post'], 'category/{id}/page-{page}', 'CatalogController@actionCategory')->where(['id' => '[0-9]+', 'page' => '[0-9]+']);
Route::match(['get', 'post'], 'category/{id}', 'CatalogController@actionCategory')->where('id', '[0-9]+');
//Basket
Route::match(['get', 'post'], 'cart/checkout', 'CartController@actionCheckout');
Route::match(['get', 'post'], 'cart/delete/{id}', 'CartController@actionDelete')->where('id', '[0-9]+');
Route::match(['get', 'post'], 'cart/add/{id}', 'CartController@actionAdd')->where('id', '[0-9]+');
Route::match(['get', 'post'], 'cart/addAjax/{id}', 'CartController@actionAddAjax')->where('id', '[0-9]+');
Route::match(['get', 'post'], 'cart', 'CartController@actionIndex');
//Cabinet
Route::match(['get', 'post'], 'cabinet/edit', 'CabinetController@actionEdit');
Route::match(['get', 'post'], 'cabinet', 'CabinetController@actionIndex');
//Manage Product
Route::match(['get', 'post'], 'admin/product/create', 'AdminProductController@actionCreate');
Route::match(['get', 'post'], 'admin/product/update/{id}', 'AdminProductController@actionUpdate')->where('id', '[0-9]+');
Route::match(['get', 'post'], 'admin/product/delete/{id}', 'AdminProductController@actionDelete')->where('id', '[0-9]+');
Route::match(['get', 'post'], 'admin/product', 'AdminProductController@actionIndex');
//Admin Panel
Route::match(['get', 'post'], 'admin', 'AdminController@actionIndex');
//About store
Route::match(['get', 'post'], 'contacts', 'SiteController@actionContact');
Route::match(['get', 'post'], 'about', 'SiteController@actionAbout');
//Main page
Route::match(['get', 'post'], '/', 'SiteController@actionIndex');

Route::get('/home', 'HomeController@index');
