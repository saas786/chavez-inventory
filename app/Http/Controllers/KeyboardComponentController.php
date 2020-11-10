<?php

namespace App\Http\Controllers;

use App\Http\Requests\IDRequest;
use App\Http\Requests\StoreKeyboardComponent;
use App\Http\Requests\UpdateColors;
use App\Models\Color;
use App\Models\KeyboardComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class KeyboardComponentController extends Controller
{
	/**
	 * Store Keyboard Component
	 *
	 * @param StoreKeyboardComponent $request
	 * @return HTTPRequest
	 */
	public function store(StoreKeyboardComponent $request)
	{
		KeyboardComponent::create($request->except(['image']));

		return Redirect::route('inventory.components')->with(
			'success',
			'Component successfully created!'
		);
	}

	/**
	 * Update Keyboard Component
	 *
	 * @param StoreKeyboardComponent $request
	 * @param KeyboardComponent $component
	 * @return HTTPRequest
	 */
	public function update(
		StoreKeyboardComponent $request,
		KeyboardComponent $component
	) {
		$component->update($request->except(['image']));

		return Redirect::route('inventory.components')->with(
			'success',
			'Component details updated!'
		);
	}

	public function debug()
	{
		$components = \App\Models\KeyboardComponent::with(
			'layout',
			'keyboardComponentType'
		)
			->get()
			->sortBy('id')
			->values();
		$components2 = \App\Models\KeyboardComponent::all();
		return ['components' => $components, 'comp2' => $components2];
	}

	/**
	 * Stock Components
	 *
	 * @param Request $request
	 * @return HTTPRequest
	 */
	public function stock(Request $request)
	{
		KeyboardComponent::stockById($request['ids'], $request['value']);

		return redirect()
			->to('/inventory/components')
			->with('success', 'Stocks successfully added!');
	}

	/**
	 * Destroy Keyboard Component
	 *
	 * @param Request $request
	 * @return HTTPRequest
	 */
	public function destroy(IDRequest $request)
	{
		KeyboardComponent::deleteById($request['ids']);

		return redirect()
			->to('/inventory/components')
			->with('success', 'Stocks successfully deleted!');
	}

	/**
	 * Get Colors
	 *
	 * @return Color
	 */
	public function colors()
	{
		return Color::all()
			->sortBy('id')
			->values();
	}

	/**
	 * Update Colors
	 *
	 * @param Request $request
	 * @return Color
	 */
	public function colorsUpdate(UpdateColors $request)
	{
		Color::colorUpdate($request['colors']);

		return Color::all();
	}
}
