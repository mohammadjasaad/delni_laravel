<?php

namespace App\Providers;

use App\Models\TaxiOrder;
use App\Observers\TaxiOrderObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

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
public function boot(): void
{
    TaxiOrder::observe(TaxiOrderObserver::class);
}

}
