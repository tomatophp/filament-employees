<?php

namespace TomatoPHP\FilamentEmployees;

use Illuminate\Support\ServiceProvider;


class FilamentEmployeesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\FilamentEmployees\Console\FilamentEmployeesInstall::class,
        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/filament-employees.php', 'filament-employees');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/filament-employees.php' => config_path('filament-employees.php'),
        ], 'filament-employees-config');

        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'filament-employees-migrations');
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-employees');

        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/filament-employees'),
        ], 'filament-employees-views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-employees');

        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => base_path('lang/vendor/filament-employees'),
        ], 'filament-employees-lang');

        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

    }

    public function boot(): void
    {
        //you boot methods here
    }
}
