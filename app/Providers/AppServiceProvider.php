<?php

namespace App\Providers;

use App\Repositories\Postgres\V1\NgosRepositoryImpl;
use App\Repositories\Postgres\V1\PrimarySectorsRepositoryImpl;
use App\Repositories\Postgres\V1\SdgsRepositoryImpl;
use App\Repositories\Postgres\V1\UsersRepositoryImpl;
use App\Repositories\V1\NgosRepository;
use App\Repositories\V1\PrimarySectorsRepository;
use App\Repositories\V1\SdgsRepository;
use App\Repositories\V1\UsersRepository;
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
        $this->app->bind(UsersRepository::class, UsersRepositoryImpl::class);
        $this->app->bind(NgosRepository::class, NgosRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
