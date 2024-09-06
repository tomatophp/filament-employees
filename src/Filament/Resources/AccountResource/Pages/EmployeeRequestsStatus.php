<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AccountResource\Pages;

use TomatoPHP\FilamentTypes\Pages\BaseTypePage;

class EmployeeRequestsStatus extends BaseTypePage
{
    public function getType(): string
    {
        return "status";
    }

    public function getFor(): string
    {
        return "employees_request";
    }


    public function getTitle(): string
    {
        return "Employee Requests Status";
    }
}
