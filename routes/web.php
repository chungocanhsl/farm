<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

/*For client*/
Route::get('/','ClientController@home');
Route::get('/shop','ClientController@shop');
Route::get('/cart','ClientController@cart');
Route::get('/checkout','ClientController@checkout');
Route::get('/login','ClientController@login');
Route::get('/signup','ClientController@signup');
Route::post('/updateqty','ClientController@updateqty');
Route::get('/removeitem/{id}','ClientController@removeitem');
Route::post('/postcheckout','ClientController@postcheckout');

/*for admin*/
Route::get('/admin','AdminController@dashboard');
Route::get('/orders','AdminController@orders');

Route::get('/addcategory','CategoryController@addcategory');
Route::post('/savecategory','CategoryController@savecategory');
Route::get('/categories','CategoryController@categories');
Route::get('/edit_category/{id}','CategoryController@edit');
Route::post('/updatecategory','CategoryController@updatecategory');
Route::get('/delete/{id}','CategoryController@delete');
Route::get('/view_by_cate/{name}','CategoryController@view_by_cate');

Route::get('/products','ProductController@products');
Route::get('/addproduct','ProductController@addproduct');
Route::post('/saveproduct','ProductController@saveproduct');
Route::get('/edit_product/{id}','ProductController@editproduct');
Route::post('/updateproduct','ProductController@updateproduct');
Route::get('/delete_product/{id}','ProductController@delete_product');
Route::get('/activate_product/{id}','ProductController@activate_product');
Route::get('/unactivate_product/{id}','ProductController@unactivate_product');
Route::get('/addToCart/{id}','ProductController@addToCart');

Route::get('/addslider','SliderController@addslider');
Route::get('/sliders','SliderController@sliders');
Route::post('/saveslider','SliderController@saveslider');
Route::get('/edit_slider/{id}','SliderController@editSlider');
Route::post('/updateslider','SliderController@updateslider');
Route::get('/delete_slider/{id}','SliderController@delete_slider');
Route::get('/unactivate_slider/{id}','SliderController@unactivate_slider');
Route::get('/activate_slider/{id}','SliderController@activate_slider');


