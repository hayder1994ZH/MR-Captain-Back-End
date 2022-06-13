<?php

namespace App\Providers;

use App\Helpers\Files;
use App\Helpers\Utilities;
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
        $this->app->bind(UserRepository::class, UserRepository::class);
        $this->app->bind(AuthRepository::class, AuthRepository::class);
        $this->app->bind(ReelsRepository::class, ReelsRepository::class);
        $this->app->bind(RulesRepository::class, RulesRepository::class);
        $this->app->bind(Utilities::class, Utilities::class);
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
