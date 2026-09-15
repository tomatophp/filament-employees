<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource;

class ListEmployeeApplies extends ListRecords
{
    protected static string $resource = EmployeeApplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('types')
                ->icon('heroicon-s-cog')
                ->tooltip('Apply Status')
                ->label('Apply Status')
                ->hiddenLabel()
                ->url(EmployeeApplyStatus::getUrl()),
        ];
    }
}
