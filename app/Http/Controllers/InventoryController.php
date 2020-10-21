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

    public function components()
    {
        return Inertia::render('Inventory/Components', [
            'components' => \App\Models\KeyboardComponent::all(),
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

    public function index()
    {
        return Inertia::render('Inventory/Index');
    }
}
