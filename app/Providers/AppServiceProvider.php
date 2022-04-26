<?php

namespace App\Providers;

use App\Contracts\ContainersCounter;
use App\Services\FractoryContainersCounter;
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
            ContainersCounter::class,
            FractoryContainersCounter::class
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
