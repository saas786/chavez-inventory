<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return Inertia::render('Inventory/Index', [
			'componentsFree' => \App\Models\KeyboardComponent::available(),
			'componentsTotal' => \App\Models\KeyboardComponent::all()->count(),
		]);
	}

	public function components()
	{
		// $components = \App\Models\KeyboardComponent::all()->map( function( $comp ){
		//         return [
		//             'id' => $comp->id,
		//             'Name' => $comp->name,
		//             'Layout' => (is_null($comp->layout)) ? '' : $comp->layout->name,
		//             'layout_id' => $comp->layout_id,
		//             'Type' => $comp->keyboardComponentType->name,
		//             'keyboard_component_type_id' => $comp->keyboard_component_type_id,
		//             'Stock' => $comp->stock,
		//             'Price' => $comp->price,
		//             'url' => $comp->url,
		//         ];
		//     });

		$components = \App\Models\KeyboardComponent::with('layout')
			->with('keyboardComponentType')
			->get()
			->sortBy('id')
			->values();

		// $components = \App\Models\KeyboardComponent::with( 'layout');

		return Inertia::render('Inventory/Components', [
			'components' => $components,
			'comp_types' => \App\Models\KeyboardComponentType::all(),
			'layouts' => \App\Models\Layout::all(),
		]);
	}

	public function keyboards()
	{
		return Inertia::render('Inventory/Keyboards');
	}

	public function prebuilt()
	{
		return Inertia::render('Inventory/Prebuilts');
	}

	public function custom()
	{
		return Inertia::render('Inventory/Customs');
	}
}
