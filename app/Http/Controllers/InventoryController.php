<?php

namespace App\Http\Controllers;

use App\Models\KeyboardComponent;
use App\Models\PrebuiltOrder;
use App\Models\Order;
use App\Models\User;
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

	public function about_faqs()
	{
		return Inertia::render('Inventory/AboutFAQs', [
			'aboutContent' => User::find(1)->about,
			'faqsContent' => User::find(1)->faqs,
		]);
	}

	public function about_faqs_update(Request $request)
	{
		User::where('id', 1)->update($request->all());

		return Inertia::render('Inventory/AboutFAQs', [
			'aboutContent' => User::find(1)->about,
			'faqsContent' => User::find(1)->faqs,
		]);
	}
}
