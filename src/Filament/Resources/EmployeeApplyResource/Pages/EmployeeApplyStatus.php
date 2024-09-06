<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages;

use TomatoPHP\FilamentTypes\Pages\BaseTypePage;

class EmployeeApplyStatus extends BaseTypePage
{
    public function getType(): string
    {
        return "status";
    }

    public function getFor(): string
    {
        return "employee_apply";
    }


    public function getTitle(): string
    {
        return "Employee Apply Status";
    }
}
