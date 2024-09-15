<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages;

use TomatoPHP\FilamentTypes\Pages\BaseTypePage;
use TomatoPHP\FilamentTypes\Services\Contracts\Type;

class EmployeePaymentsStatus extends BaseTypePage
{
    public function getType(): string
    {
        return "status";
    }

    public function getFor(): string
    {
        return "employees_payment";
    }

    public function getTypes(): array
    {
        return [
            Type::make('pending')
                ->name([
                    "ar" => "قيد الانتظار",
                    "en" => "Pending"
                ])
                ->icon('heroicon-o-clock')
                ->color('#f7b955'),
            Type::make('approved')
                ->name([
                    "ar" => "موافق",
                    "en" => "Approved"
                ])
                ->icon('heroicon-o-check-circle')
                ->color('#10e632'),
            Type::make('rejected')
                ->name([
                    "ar" => "مرفوض",
                    "en" => "Rejected"
                ])
                ->icon('heroicon-o-x-circle')
                ->color('#db1818'),
            Type::make('canceled')
                ->name([
                    "ar" => "ملغي",
                    "en" => "Canceled"
                ])
                ->icon('heroicon-o-x-circle')
                ->color('#db1818'),
        ];
    }

    public function getTitle(): string
    {
        return "Employee Payments Status";
    }
}
