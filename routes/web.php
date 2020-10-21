<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers;
use Inertia\Inertia;

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

// Route::get('/', function () {
//     return Inertia::render('Shop/Index');
// });

Route::get( '/', 'App\Http\Controllers\ShopController@index' );
Route::get( '/shop', 'App\Http\Controllers\ShopController@shop' );
Route::get( '/custom', 'App\Http\Controllers\ShopController@custom' );
Route::get( '/about', 'App\Http\Controllers\ShopController@about' );
Route::get( '/faq', 'App\Http\Controllers\ShopController@faq' );

Route::get( '/inventory', 'App\Http\Controllers\InventoryController@index' );
Route::get( '/inventory/components', 'App\Http\Controllers\InventoryController@components' );
Route::get( '/inventory/keyboards', 'App\Http\Controllers\InventoryController@keyboards' );
Route::get('/inventory/prebuilt_orders', 'App\Http\Controllers\InventoryController@prebuilt' );
Route::get('/inventory/custom_orders', 'App\Http\Controllers\InventoryController@custom' );


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
