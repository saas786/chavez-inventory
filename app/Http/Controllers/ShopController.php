<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\KeyboardComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Inertia\Inertia;

class ShopController extends Controller
{
	public function __construct()
	{
		// $this->middleware('auth');
	}

	public function index()
	{
		return Inertia::render('Shop/Index');
	}

	public function shop()
	{
		$components = KeyboardComponent::with(['layout', 'keyboardComponentType'])
			->get()
			->sortBy('keyboard_component_type_id')
			->groupBy('keyboard_component_type_id')
			->map(function ($collection) {
				return $collection
					->sortBy('price')
					->map(function ($comp) {
						return [
							'id' => Crypt::encrypt($comp->id),
							'name' => $comp->name,
							'price' => $comp->price,
							'layout_id' => $comp->layout_id,
							'stock' => $comp->availableStock,
							'url' => $comp->url,
						];
					})
					->where('stock', '>', 0)
					->values();
			})
			->values();

		$colors = Color::all()->map(function ($color) {
			return [
				'id' => Crypt::encrypt($color->id),
				'name' => $color->name,
				'hexCode' => $color->hex_code,
				'primary' => $color->primary,
				'double' => $color->double_sleeved,
			];
		});

		return Inertia::render('Shop/Shop', [
			'colors' => $colors,
			'components' => $components,
		]);
	}

	public function custom()
	{
		return Inertia::render('Shop/Custom');
	}

	public function about()
	{
		return Inertia::render('Shop/About');
	}

	public function faq()
	{
		return Inertia::render('Shop/FAQ');
	}
}
