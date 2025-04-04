<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\WantedRepositoryInterface;
use App\Repositories\WantedRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WantedRepositoryInterface::class, function ($app) {
            return new WantedRepository(new \App\API\FBIApiClient());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
