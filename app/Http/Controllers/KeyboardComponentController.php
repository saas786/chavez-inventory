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
	 * Store a keyboard component
	 *
	 * @param StoreKeyboardComponent $request
	 * @return \Illuminate\Routing\Redirector
	 */
	public function store(StoreKeyboardComponent $request)
	{
		KeyboardComponent::create($request->except(['image']));

		return Redirect::route('inventory.components.index')->with(
			'success',
			'Component successfully created!'
		);
	}

	/**
	 * Update a keyboard component.
	 *
	 * @param StoreKeyboardComponent $request
	 * @param KeyboardComponent $component
	 * @return \Illuminate\Routing\Redirector
	 */
	public function update(
		StoreKeyboardComponent $request,
		KeyboardComponent $component
	) {
		$component->update($request->except(['image']));

		return Redirect::route('inventory.components.index')->with(
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
	 * @return \Illuminate\Routing\Redirector
	 */
	public function stock(Request $request)
	{
		KeyboardComponent::stockById($request['ids'], $request['value']);

		return Redirect::route('inventory.components.index')->with(
			'success',
			'Stocks successfully added!'
		);
	}

	/**
	 * Destroy Keyboard Component
	 *
	 * @param Request $request
	 * @return \Illuminate\Routing\Redirector
	 */
	public function destroy(IDRequest $request)
	{
		KeyboardComponent::deleteById($request['ids']);

		return Redirect::route('inventory.components.index')->with(
			'success',
			'Stocks successfully deleted!'
		);
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
