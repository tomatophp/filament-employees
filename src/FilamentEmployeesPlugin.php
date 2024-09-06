<?php

namespace TomatoPHP\FilamentEmployees;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use TomatoPHP\FilamentEmployees\Filament\Resources\AccountResource;
use TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource;


class FilamentEmployeesPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-employees';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            AccountResource::class,
            AttendanceShiftResource::class,
            EmployeeApplyResource::class
        ])
        ->pages([
            Filament\Resources\AccountResource\Pages\EmployeePaymentsStatus::class,
            Filament\Resources\AccountResource\Pages\EmployeePaymentsType::class,
            Filament\Resources\AccountResource\Pages\EmployeeRequestsStatus::class,
            Filament\Resources\AccountResource\Pages\Departments::class,
            Filament\Resources\EmployeeApplyResource\Pages\EmployeeApplyStatus::class,
        ]);
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
