<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages;

use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeApplies extends ListRecords
{
    protected static string $resource = EmployeeApplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('types')
                ->icon('heroicon-s-cog')
                ->tooltip('Apply Status')
                ->label('Apply Status')
                ->hiddenLabel()
                ->url(EmployeeApplyStatus::getUrl())
        ];
    }
}
