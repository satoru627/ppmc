<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

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
    // public function boot(): void
    // {
    //     view::share('appName', 'Hack App');
    // }
   {
      if (app()->environment('production')) {
          URL::forceScheme('https');
      }

      view::share('framework', 'Laravel');
  }


}
