<?php

namespace App\Http\Controllers;

use App\Models\KeyboardComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Throwable;

class KeyboardComponentController extends Controller
{
    public function store( Request $request ){
        
        $valid = $request->validateWithBag( 'components', [
            'name' => 'required',
            'layout_id' => 'exclude_if:keyboard_component_type_id,1|exclude_if:keyboard_component_type_id,2',
            'keyboard_component_type_id' => 'required',
            'price' => 'numeric|nullable',
            'stock' => 'integer|nullable',
            'image' => 'image|nullable',
        ]);

        $image_url = null;

        if( !!$request['image'] )
            $image_url = $request->file('image')->store('images', 's3');

        $comp = KeyboardComponent::create([
            'name' => $valid['name'],
            'layout_id' => Arr::get($valid, 'layout_id', null),
            'keyboard_component_type_id' => $valid['keyboard_component_type_id'],
            'price' => $valid['price'] || 0,
            'stock' => $valid['stock'] || 0,
            'image_url' => $image_url,
        ]);

        return Redirect::route('inventory.components')->with( 'success', 'Component successfully created!');

    }

    public function image_url( $id ){
        $comp = KeyboardComponent::find($id);
        if( $comp->image_url != null )
            return Storage::disk('s3')->url( $comp->image_url );
        return null;
    }

}
