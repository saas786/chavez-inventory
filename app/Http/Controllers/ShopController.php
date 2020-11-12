<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCustomKeyboard;
use App\Models\Cable;
use App\Models\Color;
use App\Models\CustomOrder;
use App\Models\Keyboard;
use App\Models\KeyboardComponent;
use App\Models\Order;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ShopController extends Controller
{
	public function __construct()
	{
		// $this->middleware('auth');
	}

	/**
	 * Go to the shop index
	 *
	 * @return Inertia\Response
	 */
	public function index()
	{
		return Inertia::render('Shop/Index');
	}

	public function shop()
	{
		return Inertia::render('Shop/Shop');
	}

	/**
	 * Show page for the custom keyboards.
	 *
	 * @return Inertia\Response
	 */
	public function custom()
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

		return Inertia::render('Shop/Custom', [
			'colors' => $colors,
			'components' => $components,
		]);
	}

	/**
	 * Create a custom order.
	 *
	 * @param OrderCustomKeyboard $request
	 * @return \App\Models\Order
	 */
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
			'tracking_id' => Str::random(15),
		]);

		$order
			->orderable()
			->associate($customOrder)
			->save();

		sleep(5);

		return Response::json(
			[
				'success' => 'Ordered successfully!',
				'tracking_id' => $order->tracking_id,
			],
			201
		);
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
