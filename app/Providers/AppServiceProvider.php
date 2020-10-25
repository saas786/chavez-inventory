<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        Inertia::share( [
            'auth.user' => function() {
                return Auth::user();
            },
            'error' => function () {
                if ($errors = session('errors')) {
                    $bags = [];

                    foreach ($errors->getBags() as $name => $bag) {
                        $bags[$name] = $bag->getMessages();
                    }

                    return (object)$bags;
                }
                
                return (object)[];
            },
            'flash' => function () {
                $bags = null;
                if( $errors = Session::get('errors') ){
                    $bags = [];
                    foreach( $errors->getBags() as $name => $bag ){
                        $messages = [];
                        foreach( $bag->getMessages() as $category => $message ){
                            array_push( $messages, [
                                'name' => $category,
                                'content' => $message,
                            ]);
                        }

                        array_push( $bags, [
                            'bag' => $name,
                            'message' => $messages,
                        ]);
                    }
                }
                return [
                    'errors' => $bags,
                    'success' => Session::get('success'),
                ];
            },
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
