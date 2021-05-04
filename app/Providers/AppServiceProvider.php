<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $footer = \App\Web\About::findOrFail(1);

        View::share(['footer' => $footer]);
        if (env('APP_ENV') == 'production') {
            URL::forceScheme('https');
        }
    }
}
