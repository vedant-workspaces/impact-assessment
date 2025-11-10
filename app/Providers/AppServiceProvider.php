<?php

namespace App\Providers;

use App\Repositories\Postgres\V1\PrimarySectorsRepositoryImpl;
use App\Repositories\V1\PrimarySectorsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PrimarySectorsRepository::class,
            PrimarySectorsRepositoryImpl::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
