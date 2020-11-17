<?php

namespace App\Http\Controllers;

use App\Models\KeyboardComponent;
use App\Models\PrebuiltOrder;
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
		$components = \App\Models\KeyboardComponent::with('layout')
			->with('keyboardComponentType')
			->get()
			->sortBy('id')
			->values();

		return Inertia::render('Inventory/Components', [
			'components' => $components,
			'comp_types' => \App\Models\KeyboardComponentType::all(),
			'layouts' => \App\Models\Layout::all(),
		]);
	}

	public function catalog()
	{
		return Inertia::render('Inventory/Catalog', [
			'components' => KeyboardComponent::categorizedComponents(false),
			'catalog_items' => PrebuiltOrder::with(
				'keyboard',
				'keyboard.cable'
			)->get(),
		]);
	}

	public function orders()
	{
		return Inertia::render('Inventory/Orders');
	}
}
