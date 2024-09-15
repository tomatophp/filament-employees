<?php

namespace TomatoPHP\FilamentEmployees;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource;
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
            EmployeeResource::class,
            AttendanceShiftResource::class,
            EmployeeApplyResource::class
        ])
        ->pages([
            Filament\Resources\EmployeeResource\Pages\EmployeePaymentsStatus::class,
            Filament\Resources\EmployeeResource\Pages\EmployeePaymentsType::class,
            Filament\Resources\EmployeeResource\Pages\EmployeeRequestsStatus::class,
            Filament\Resources\EmployeeResource\Pages\Departments::class,
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
