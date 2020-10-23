<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class KeyboardComponentController extends Controller
{
    public function store( Request $request ){
        
        $request->validateWithBag( 'components', [
            'image' => 'image|nullable'
        ]);

        return Redirect::route('inventory.components')->with( 'success', 'Component successfully created!');

    }
}
