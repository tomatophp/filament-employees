<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AccountResource\Pages;

use TomatoPHP\FilamentTypes\Pages\BaseTypePage;

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

    public function getTitle(): string
    {
        return "Employee Payments Status";
    }
}
