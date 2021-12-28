<?php

namespace App\Providers;

use App\Entities\Repositories\Projects\Repository as ProjectsRepositoryContract;
use App\Entities\Repositories\Projects\ValetAssistantRepository as ProjectsValetAssistantRepository;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
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
        $this->app->bind(ProjectsRepositoryContract::class, ProjectsValetAssistantRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Date::use(CarbonImmutable::class);
    }
}
