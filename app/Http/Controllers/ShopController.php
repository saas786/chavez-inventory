<?php

namespace App\Http\Controllers;

use App\Models\Cable;
use App\Models\Color;
use App\Models\Keyboard;
use App\Models\KeyboardComponent;
use Error;
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

	public function custom_order(Request $request)
	{
		// $decrypted = [
		// 	'layout_id' => $request['keyboard']['layout'],
		// 	'switch_id' => Crypt::decrypt($request['keyboard']['switch']),
		// 	'keycap_id' => Crypt::decrypt($request['keyboard']['keycap']),
		// 	'plate_id' => Crypt::decrypt($request['keyboard']['plate']),
		// 	'case_id' => Crypt::decrypt($request['keyboard']['case']),
		// ];

		// return $decrypted;

		// $cable = Cable::firstOrCreate([
		// 	'cable_length' => $request['keyboard']['cable']['cable_length'],
		// 	'coil_length' => $request['keyboard']['cable']['coil_length'],
		// 	'color_id' => $request['keyboard']['cable']['color_id'],
		// 	'double_sleeved' => $request['keyboard']['cable']['double_sleeved'],
		// 	'double_sleeve_color_id' =>
		// 		$request['keyboard']['cable']['double_sleeve_color_id'],
		// 	'detachable' => $request['keyboard']['cable']['detachable'],
		// ]);

		$cable = Cable::firstOrCreate($request['keyboard']['cable']);

		$keyboard = Keyboard::create([
			'layout_id' => $request['keyboard']['layout'],
			'switch_id' => Crypt::decrypt($request['keyboard']['switch']),
			'keycap_id' => Crypt::decrypt($request['keyboard']['keycap']),
			'cable_id' => $cable->id,
			'plate_id' => Crypt::decrypt($request['keyboard']['plate']),
			'case_id' => Crypt::decrypt($request['keyboard']['case']),
		]);

		return $keyboard;
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
