<?php

namespace TomatoPHP\FilamentEmployees;

use Filament\Contracts\Plugin;
use Filament\Panel;


class FilamentEmployeesPlugin implements Plugin
{
    protected array $routes = [];
    public function getId(): string
    {
        return 'filament-employees';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static();
    }
}
