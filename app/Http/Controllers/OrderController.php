<?php

namespace App\Http\Controllers;

use App\Http\Requests\IDRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class OrderController extends Controller
{
	public function index()
	{
		return Inertia::render('Inventory/Orders', [
			'orders' => Order::with(
				'orderable.keyboard.cable.color',
				'orderable.keyboard.cable.double_sleeve_color'
			)->get(),
		]);
	}

	public function update(IDRequest $request)
	{
		Order::updateById($request['ids'], $request['value']);

		return Redirect::route('inventory.orders.index')->with(
			'success',
			'Orders successfully updated!'
		);
	}

	public function check()
	{
		return Inertia::render('Shop/Check');
	}

	public function show(Order $order)
	{
		return Inertia::render('Shop/Check', [
			'order' => Order::where('id', $order->id)
				->with(
					'orderable.keyboard.cable.color',
					'orderable.keyboard.cable.double_sleeve_color'
				)
				->get()[0],
		]);
	}
}
