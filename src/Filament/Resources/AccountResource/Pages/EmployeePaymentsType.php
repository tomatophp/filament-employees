<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AccountResource\Pages;

use TomatoPHP\FilamentTypes\Pages\BaseTypePage;
use TomatoPHP\FilamentTypes\Services\Contracts\Type;

class EmployeePaymentsType extends BaseTypePage
{
    public function getType(): string
    {
        return "reason";
    }

    public function getFor(): string
    {
        return "employee_payments";
    }

    public function getTypes(): array
    {
        return [
            Type::make('reward')
                ->name([
                    "ar" => "مكافأة",
                    "en" => "Reward"
                ])
                ->icon('heroicon-o-gift')
                ->color('#10e632'),
            Type::make('deduction')
                ->name([
                    "ar" => "خصم",
                    "en" => "Deduction"
                ])
                ->icon('heroicon-o-receipt-percent')
                ->color('#db1818'),
            Type::make('bonus')
                ->name([
                    "ar" => "اضافي",
                    "en" => "Bonus"
                ])
                ->icon('heroicon-o-plus-circle')
                ->color('#10e632'),
            Type::make('payroll')
                ->name([
                    "ar" => "مرتب",
                    "en" => "Payroll"
                ])
                ->icon('heroicon-o-currency-dollar')
                ->color('#10e632'),
            Type::make('advance')
                ->name([
                    "ar" => "سلفة",
                    "en" => "Advance"
                ])
                ->icon('heroicon-o-arrow-path-rounded-square')
                ->color('#db1818'),
            Type::make('other')
                ->name([
                    "ar" => "أخرى",
                    "en" => "Other"
                ])
                ->icon('heroicon-o-currency-dollar')
                ->color('#e0bf12'),
        ];
    }


    public function getTitle(): string
    {
        return "Employee Payments Reasons";
    }
}
