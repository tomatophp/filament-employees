<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource;

class EditEmployeeApply extends EditRecord
{
    protected static string $resource = EmployeeApplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
