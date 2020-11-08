<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\KeyboardComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Throwable;

class KeyboardComponentController extends Controller
{
	public function store(Request $request)
	{
		$valid = $request->validateWithBag('componentStore', [
			'name' => 'required',
			'layout_id' =>
				'exclude_if:keyboard_component_type_id,1|exclude_if:keyboard_component_type_id,2',
			'keyboard_component_type_id' => 'required',
			'price' => 'numeric|nullable',
			'stock' => 'integer|nullable',
			'image' => 'image|nullable',
		]);

		$image_url = null;

		if (!!$request['image']) {
			$image_url = $request->file('image')->store('images', 's3');
		}

		KeyboardComponent::create([
			'name' => $valid['name'],
			'layout_id' => Arr::get($valid, 'layout_id', null),
			'keyboard_component_type_id' => $valid['keyboard_component_type_id'],
			'price' => $valid['price'],
			'stock' => $valid['stock'],
			'image_url' => $image_url,
		]);

		return Redirect::route('inventory.components')->with(
			'success',
			'Component successfully created!'
		);
	}

	public function update(Request $request, KeyboardComponent $component)
	{
		$validatedFillables = $request->validateWithBag('componentUpdate', [
			'name' => 'required',
			'layout_id' =>
				'exclude_if:keyboard_component_type_id,1|exclude_if:keyboard_component_type_id,2',
			'keyboard_component_type_id' => 'required',
			'price' => 'numeric|nullable',
			'stock' => 'integer|nullable',
			'image' => 'image|nullable',
		]);

		if (!!$validatedFillables['image']) {
			$validatedFillables['image_url'] = $request
				->file('image')
				->store('images', 's3');
		}

		unset($validatedFillables['image']);

		$component->update($validatedFillables);

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

	public function stock(Request $request)
	{
		foreach ($request['componentIds'] as $id) {
			$component = KeyboardComponent::findOrFail($id);
			$component->stock += $request['stockAdd'];
			$component->save();
		}

		return redirect()
			->to('/inventory/components')
			->with('success', 'Stocks successfully added!');
	}

	public function destroy(Request $request)
	{
		foreach ($request['componentIds'] as $id) {
			$component = KeyboardComponent::findOrFail($id);
			$component->delete();
		}

		return redirect()
			->to('/inventory/components')
			->with('success', 'Stocks successfully deleted!');
	}

	public function image_url($id)
	{
		$comp = KeyboardComponent::find($id);
		if ($comp->image_url != null) {
			return Storage::disk('s3')->url($comp->image_url);
		}
		return null;
	}

	public function colors()
	{
		return Color::all()
			->sortBy('id')
			->values();
	}

	public function colorsUpdate(Request $request)
	{
		foreach (Color::all() as $color) {
			$color->delete();
		}

		foreach ($request->all() as $color) {
			$color_model = Color::withTrashed()->firstOrNew([
				'name' => $color['name'],
			]);
			if ($color_model->trashed()) {
				$color_model->restore();
			}

			$color_model->name = $color['name'];
			$color_model->hex_code = $color['hexCode'];
			$color_model->primary = $color['primary'];
			$color_model->double_sleeved = $color['double'];
			$color_model->save();
		}

		return Color::all();
	}
}
