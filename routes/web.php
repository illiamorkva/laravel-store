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
//About store
Route::match(['get', 'post'], 'contacts', 'SiteController@actionContact');
Route::match(['get', 'post'], 'about', 'SiteController@actionAbout');
//Main page
Route::match(['get', 'post'], '/', 'SiteController@actionIndex');

Route::get('/home', 'HomeController@index');
