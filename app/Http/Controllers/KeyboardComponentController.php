<?php

namespace App\Http\Controllers;

use App\Models\KeyboardComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class KeyboardComponentController extends Controller
{
    public function store( Request $request ){
        
        $request->validateWithBag( 'components', [
            'image' => 'image|nullable'
        ]);

        $image_url = '';

        if( !!$request['image'] )
            $image_url = $request->file('image')->store('images', 's3');

        $comp = KeyboardComponent::create([
            'name' => $request['name'],
            'layout_id' => $request['layout_id'] || null,
            'keyboard_component_type_id' => $request['keyboard_component_type_id'],
            'price' => $request['price'],
            'stock' => $request['stock'],
            'image_url' => $image_url,
        ]);

        return Redirect::route('inventory.components')->with( 'success', 'Component successfully created!');

    }

    public function image_url( $id ){
        $comp = KeyboardComponent::find($id);
        // return $comp->image_url;
        if( $comp->image_url != null )
            return Storage::disk('s3')->url( $comp->image_url );
        return null;
    }

}
