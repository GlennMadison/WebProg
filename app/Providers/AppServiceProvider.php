<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\URL;
>>>>>>> 6f2c45d (Udah Jadi)
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Paginator::useBootstrap();
<<<<<<< HEAD
=======
        if(config('app.env') === 'production') {
                URL::forceScheme('https');
        }
>>>>>>> 6f2c45d (Udah Jadi)
    }
}
