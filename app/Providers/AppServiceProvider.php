<?php

namespace App\Providers;

use App\Repositories\Postgres\V1\MemberRepositoryImpl;
use App\Repositories\Postgres\V1\NgoRepositoryImpl;
use App\Repositories\Postgres\V1\PrimarySectorRepositoryImpl;
use App\Repositories\Postgres\V1\ProgramMembersRepositoryImpl;
use App\Repositories\Postgres\V1\ProgramRepositoryImpl;
use App\Repositories\Postgres\V1\SurveyMembersRepositoryImpl;
use App\Repositories\Postgres\V1\SurveyRepositoryImpl;
use App\Repositories\Postgres\V1\SdgRepositoryImpl;
use App\Repositories\Postgres\V1\UserRepositoryImpl;
use App\Repositories\V1\MemberRepository;
use App\Repositories\V1\NgoRepository;
use App\Repositories\V1\PrimarySectorRepository;
use App\Repositories\V1\ProgramMembersRepository;
use App\Repositories\V1\ProgramRepository;
use App\Repositories\V1\SurveyMembersRepository;
use App\Repositories\V1\SurveyRepository;
use App\Repositories\V1\SdgRepository;
use App\Repositories\V1\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PrimarySectorRepository::class, PrimarySectorRepositoryImpl::class);
        $this->app->bind(SdgRepository::class, SdgRepositoryImpl::class);
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
        $this->app->bind(NgoRepository::class, NgoRepositoryImpl::class);
        $this->app->bind(MemberRepository::class, MemberRepositoryImpl::class);
        $this->app->bind(ProgramRepository::class, ProgramRepositoryImpl::class);
        $this->app->bind(ProgramMembersRepository::class, ProgramMembersRepositoryImpl::class);
        $this->app->bind(SurveyRepository::class, SurveyRepositoryImpl::class);
        $this->app->bind(SurveyMembersRepository::class, SurveyMembersRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
