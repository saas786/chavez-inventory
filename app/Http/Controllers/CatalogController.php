<?php

namespace App\Http\Controllers;

use App\Http\Requests\IDRequest;
use App\Http\Requests\StoreCatalogItem;
use App\Models\Cable;
use App\Models\Keyboard;
use App\Models\PrebuiltOrder;
use Illuminate\Support\Facades\Redirect;

class CatalogController extends Controller
{
	public function store(StoreCatalogItem $request)
	{
		$valid = $request->validated();

		$valid['keyboard']['cable_id'] = Cable::firstOrCreate($valid['cable'])->id;

		$valid['catalog_item']['keyboard_id'] = Keyboard::create(
			$valid['keyboard']
		)->id;

		$valid['catalog_item']['image_url'] = $request['catalog_item']['image_url'];

		$catalog_item = PrebuiltOrder::create($valid['catalog_item']);

		return Redirect::route('inventory.catalog.index')->with(
			'success',
			'Created catalog item!'
		);
	}

	public function destroy(IDRequest $request)
	{
		PrebuiltOrder::deleteMultiple($request['ids']);

		return Redirect::route('inventory.catalog.index')->with(
			'success',
			'Deleted item(s)'
		);
	}

	public function update(StoreCatalogItem $request, PrebuiltOrder $item)
	{
		$valid = $request->validated();

		$valid['keyboard']['cable_id'] = Cable::firstOrCreate($valid['cable'])->id;

		$item->keyboard->update($valid['keyboard']);

		$valid['catalog_item']['image_url'] = $request['catalog_item']['image_url'];

		$item->update([
			'name' => $valid['catalog_item']['name'],
			'price' => $valid['catalog_item']['price'],
			'description' => $valid['catalog_item']['description'],
			'image_url' =>
				$valid['catalog_item']['image_url'] == null
					? $item->image_url
					: $valid['catalog_item']['image_url'],
		]);

		return Redirect::route('inventory.catalog.index')->with(
			'success',
			'Created catalog item!'
		);
	}
}
