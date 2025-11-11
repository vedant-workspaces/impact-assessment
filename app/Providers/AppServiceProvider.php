<?php

namespace App\Providers;

use App\Repositories\Postgres\V1\PrimarySectorsRepositoryImpl;
use App\Repositories\Postgres\V1\SdgsRepositoryImpl;
use App\Repositories\V1\PrimarySectorsRepository;
use App\Repositories\V1\SdgsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PrimarySectorsRepository::class, PrimarySectorsRepositoryImpl::class);
        $this->app->bind(SdgsRepository::class, SdgsRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
