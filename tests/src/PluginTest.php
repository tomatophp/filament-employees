<?php

use Filament\Facades\Filament;
use TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages\EmployeeApplyStatus;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\Departments;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EmployeePaymentsStatus;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EmployeePaymentsType;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EmployeeRequestsStatus;
use TomatoPHP\FilamentEmployees\FilamentEmployeesPlugin;

it('registers the plugin on the panel', function () {
    $panel = Filament::getCurrentOrDefaultPanel();

    expect($panel->getPlugin('filament-employees'))->toBeInstanceOf(FilamentEmployeesPlugin::class);
});

it('registers the resources and settings pages', function () {
    $panel = Filament::getCurrentOrDefaultPanel();

    expect($panel->getResources())->toContain(
        EmployeeResource::class,
        AttendanceShiftResource::class,
        EmployeeApplyResource::class,
    );

    expect($panel->getPages())->toContain(
        Departments::class,
        EmployeePaymentsStatus::class,
        EmployeePaymentsType::class,
        EmployeeRequestsStatus::class,
        EmployeeApplyStatus::class,
    );
});
