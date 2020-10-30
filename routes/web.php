<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\KeyboardComponentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop.prebuilt');
Route::get('/custom', [ShopController::class, 'custom'])->name('shop.custom');
Route::get('/about', [ShopController::class, 'about'])->name('shop.about');
Route::get('/faq', [ShopController::class, 'faq'])->name('shop.faq');

Route::get('/inventory/components/debug', [
	KeyboardComponentController::class,
	'debug',
])->name('components.debug');
Route::post('/inventory/components/stock', [
	KeyboardComponentController::class,
	'stock',
])->name('components.stock');
Route::post('/inventory/components/{component}', [
	KeyboardComponentController::class,
	'update',
])->name('components.update');
Route::delete('/inventory/components/', [
	KeyboardComponentController::class,
	'destroy',
])->name('components.delete');
Route::post('/inventory/components', [
	KeyboardComponentController::class,
	'store',
])->name('components.store');
Route::get('/inventory', [InventoryController::class, 'index'])->name(
	'inventory.index'
);

Route::get('/inventory/keyboards', [
	InventoryController::class,
	'keyboards',
])->name('inventory.keyboards');
Route::get('/inventory/prebuilt_orders', [
	InventoryController::class,
	'prebuilt',
])->name('inventory.prebuilts');
Route::get('/inventory/custom_orders', [
	InventoryController::class,
	'custom',
])->name('inventory.customs');
Route::get('/inventory/components', [
	InventoryController::class,
	'components',
])->name('inventory.components');

//Auth Routes
Route::get(
	'/login',
	'App\Http\Controllers\Auth\LoginController@showLoginForm'
)->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post(
	'/logout',
	'App\Http\Controllers\Auth\LoginController@logout'
)->name('logout');

Route::get('/home', [
	App\Http\Controllers\HomeController::class,
	'index',
])->name('home');
