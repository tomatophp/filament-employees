<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages;

use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeApply extends EditRecord
{
    protected static string $resource = EmployeeApplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
