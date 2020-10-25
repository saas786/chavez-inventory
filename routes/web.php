<?php

use Illuminate\Support\Facades\Auth;
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

Route::get( '/', 'App\Http\Controllers\ShopController@index' )->name('shop.index');
Route::get( '/shop', 'App\Http\Controllers\ShopController@shop' )->name('shop.prebuilt');
Route::get( '/custom', 'App\Http\Controllers\ShopController@custom' )->name('shop.custom');
Route::get( '/about', 'App\Http\Controllers\ShopController@about' )->name('shop.about');
Route::get( '/faq', 'App\Http\Controllers\ShopController@faq' )->name('shop.faq');

Route::get( '/inventory', 'App\Http\Controllers\InventoryController@index' )->name('inventory.index');
Route::get( '/inventory/components', 'App\Http\Controllers\InventoryController@components' )->name('inventory.components');
Route::get( '/inventory/keyboards', 'App\Http\Controllers\InventoryController@keyboards' )->name('inventory.keyboards');
Route::get('/inventory/prebuilt_orders', 'App\Http\Controllers\InventoryController@prebuilt' )->name('inventory.prebuilts');
Route::get('/inventory/custom_orders', 'App\Http\Controllers\InventoryController@custom' )->name('inventory.customs');

Route::post( '/inventory/components', 'App\Http\Controllers\KeyboardComponentController@store');
Route::get( '/images/components/{id}', 'App\Http\Controllers\KeyboardComponentController@image_url');

//Auth Routes
Route::get( '/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post( '/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post( '/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// Auth::routes([
//     'register' => false,
//     'reset' => false,
//     'verify' => false,
// ]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
