<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AccountResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentEmployees\Filament\Resources\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccounts extends ManageRecords
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ActionGroup::make([
                Actions\Action::make('departments')
                    ->url(Departments::getUrl())
            ])
        ];
    }


}
