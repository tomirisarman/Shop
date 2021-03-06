<?php

use App\Product;
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

Route::get('/', 'MainController@shopMenu')->name('shop');
Route::get('/add_to_cart/{id}', 'MainController@addToCart')->name('addToCart');
Route::get('/remove_from_cart/{id}', 'MainController@removeFromCart')->name('removeFromCart');
Route::get('/cart', 'MainController@viewCart')->name('viewCart');
Route::get('/auth_to_order/{hasAccount}', 'MainController@redirectLoginRegister')->name('redirLogReg');
Route::post('/order', 'MainController@createOrder')->name('order');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
