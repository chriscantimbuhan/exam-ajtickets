<?php

namespace App\Burger\Providers;

use App\Burger\Commands\BurgerBuild;
use App\Burger\Commands\BurgerManageComponent;
use Illuminate\Support\ServiceProvider;

class BurgerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMigrations();
        $this->registerCommands();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 
    }

    /**
     * Register migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(app_path('Burger/Migrations'));
    }

    /**
     * Register commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BurgerBuild::class,
                BurgerManageComponent::class
            ]);
        }
    }
}
