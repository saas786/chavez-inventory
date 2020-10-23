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
                return [
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
