<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatalogItem;
use App\Models\Cable;
use App\Models\Keyboard;
use App\Models\PrebuiltOrder;

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

		dd($catalog_item);
	}
}
