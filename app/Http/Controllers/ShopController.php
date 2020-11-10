<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCustomKeyboard;
use App\Models\Cable;
use App\Models\Color;
use App\Models\CustomOrder;
use App\Models\Keyboard;
use App\Models\KeyboardComponent;
use App\Models\Order;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;
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

	public function custom_order(OrderCustomKeyboard $request)
	{
		// return $request->all();

		$valid = $request->validated();

		$valid['keyboard']['cable_id'] = Cable::firstOrCreate($valid['cable'])->id;

		$keyboard = Keyboard::create($valid['keyboard']);

		$customOrder = CustomOrder::create([
			'keyboard_id' => $keyboard->id,
			'remarks' => $request['customer']['remarks'],
		]);

		// return $keyboard;

		$order = new Order([
			'customer_name' => $valid['customer']['name'],
			'messenger_name' => $valid['customer']['messenger'],
		]);

		$order
			->orderable()
			->associate($customOrder)
			->save();

		return $order;
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
