<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\KeyboardComponentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

//Shop Routes
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop.prebuilt');
Route::post('/custom', [ShopController::class, 'custom_order'])->name(
	'shop.custom_order'
);
Route::get('/custom', [ShopController::class, 'custom'])->name('shop.custom');
Route::get('/about', [ShopController::class, 'about'])->name('shop.about');
Route::get('/faq', [ShopController::class, 'faq'])->name('shop.faq');

//Authorized Routes
Route::middleware(['auth'])->group(function () {
	Route::prefix('inventory')->group(function () {
		Route::get('/', [InventoryController::class, 'index'])->name(
			'inventory.index'
		);

		Route::prefix('components')->group(function () {
			Route::post('/stock', [
				KeyboardComponentController::class,
				'stock',
			])->name('inventory.components.stock');

			Route::post('/colors', [
				KeyboardComponentController::class,
				'colorsUpdate',
			])->name('inventory.components.colors.update');

			Route::get('/colors', [
				KeyboardComponentController::class,
				'colors',
			])->name('inventory.components.colors');

			Route::post('/{component}', [
				KeyboardComponentController::class,
				'update',
			])->name('inventory.components.update');

			Route::delete('/', [KeyboardComponentController::class, 'destroy'])->name(
				'inventory.components.delete'
			);

			Route::post('/', [KeyboardComponentController::class, 'store'])->name(
				'inventory.components.store'
			);

			Route::get('/', [InventoryController::class, 'components'])->name(
				'inventory.components.index'
			);
		});

		Route::prefix('catalog')->group(function () {
			Route::get('/', [InventoryController::class, 'catalog'])->name(
				'inventory.catalog.index'
			);
			Route::post('/', [CatalogController::class, 'store'])->name(
				'inventory.catalog.store'
			);
			Route::delete('/', [CatalogController::class, 'destroy'])->name(
				'inventory.catalog.destroy'
			);
			Route::patch('/{item}', [CatalogController::class, 'update'])->name(
				'inventory.catalog.update'
			);
		});

		Route::prefix('orders')->group(function () {
			Route::get('/', [InventoryController::class, 'orders'])->name(
				'inventory.orders.index'
			);
		});
	});
});

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
