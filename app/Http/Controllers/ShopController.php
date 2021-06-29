<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCustomKeyboard;
use App\Http\Requests\OrderPrebuiltKeyboard;
use App\Models\Cable;
use App\Models\Color;
use App\Models\CustomOrder;
use App\Models\Keyboard;
use App\Models\KeyboardComponent;
use App\Models\Order;
use App\Models\PrebuiltOrder;
use App\Models\User;
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
		return Inertia::render('Shop/Shop', [
			'catalog' => PrebuiltOrder::with(
				'keyboard',
				'keyboard.cable',
				'keyboard.cable.color',
				'keyboard.cable.double_sleeve_color'
			)->get(),
		]);
	}

	public function shop_order(OrderPrebuiltKeyboard $request)
	{
		$order = new Order($request->except('prebuilt_order_id'));

		$order
			->orderable()
			->associate(PrebuiltOrder::find($request['prebuilt_order_id']))
			->save();

		return Response::json(
			[
				'success' => 'Ordered successfully!',
				'tracking_id' => $order->tracking_id,
			],
			201
		);
	}

	/**
	 * Show page for the custom keyboards.
	 *
	 * @return Inertia\Response
	 */
	public function custom()
	{
		return Inertia::render('Shop/Custom', [
			'components' => KeyboardComponent::categorizedComponents(true),
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
		$valid = $request->validated();

		$valid['keyboard']['cable_id'] = Cable::firstOrCreate($valid['cable'])->id;

		$keyboard = Keyboard::create($valid['keyboard']);

		$customOrder = CustomOrder::create([
			'keyboard_id' => $keyboard->id,
			'remarks' => $request['customer']['remarks'],
		]);

		$order = new Order([
			'customer_name' => $valid['customer']['name'],
			'messenger_name' => $valid['customer']['messenger'],
			'tracking_id' => Str::random(15),
		]);

		$order
			->orderable()
			->associate($customOrder)
			->save();

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
		return Inertia::render('Shop/Info', [
			'content' => User::find(1)->about,
		]);
	}

	public function faq()
	{
		return Inertia::render('Shop/Info', [
			'content' => User::find(1)->faqs,
		]);
	}
}
