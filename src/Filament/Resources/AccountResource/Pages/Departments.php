<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AccountResource\Pages;

use TomatoPHP\FilamentTypes\Pages\BaseTypePage;

class Departments extends BaseTypePage
{
    public function getType(): string
    {
        return "departments";
    }

    public function getFor(): string
    {
        return "employees";
    }


    public function getTitle(): string
    {
        return "Departments";
    }

}
