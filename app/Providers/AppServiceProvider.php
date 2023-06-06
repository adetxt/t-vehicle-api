<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Interfaces\VehicleRepository::class,
            \App\Repositories\VehicleRepository::class
        );

        $this->app->bind(
            \App\Interfaces\VehicleService::class,
            \App\Services\VehicleService::class
        );
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
