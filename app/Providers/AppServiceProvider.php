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

        $this->app->bind(
            \App\Interfaces\SaleRepository::class,
            \App\Repositories\SaleRepository::class
        );

        $this->app->bind(
            \App\Interfaces\SaleService::class,
            \App\Services\SaleService::class
        );

        $this->app->bind(
            \App\Interfaces\ReportService::class,
            \App\Services\ReportService::class
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
