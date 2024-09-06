<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AccountResource\Pages;

use TomatoPHP\FilamentTypes\Pages\BaseTypePage;

class EmployeePaymentsType extends BaseTypePage
{
    public function getType(): string
    {
        return "type";
    }

    public function getFor(): string
    {
        return "employees_payment";
    }


    public function getTitle(): string
    {
        return "Employee Payments Type";
    }
}
