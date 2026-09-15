<?php

namespace TomatoPHP\FilamentEmployees;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages\EmployeeApplyStatus;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\Departments;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EmployeePaymentsStatus;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EmployeePaymentsType;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EmployeeRequestsStatus;

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
            EmployeeApplyResource::class,
        ])
            ->pages([
                EmployeePaymentsStatus::class,
                EmployeePaymentsType::class,
                EmployeeRequestsStatus::class,
                Departments::class,
                EmployeeApplyStatus::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): self
    {
        return new self;
    }
}
