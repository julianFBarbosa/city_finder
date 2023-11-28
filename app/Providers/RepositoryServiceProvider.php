<?php

namespace App\Providers;

use App\Repositories\Contracts\{
    CityRepositoryInterface,
};
use App\Repositories\{
    CityRepository,
};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CityRepositoryInterface::class,
            CityRepository::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
