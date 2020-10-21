<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(){
        return Inertia::render( 'Shop/Index' );
    }

    public function shop(){
        return Inertia::render( 'Shop/Shop' );
    }

    public function custom(){
        return Inertia::render( 'Shop/Custom' );
    }

    public function about(){
        return Inertia::render( 'Shop/About' );
    }

    public function faq(){
        return Inertia::render( 'Shop/FAQ' );
    }

}
