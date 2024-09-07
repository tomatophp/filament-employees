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
                    ->label('Departments')
                    ->url(Departments::getUrl()),
                Actions\Action::make('employees_payment')
                    ->label('Employee Payment Reasons')
                    ->url(EmployeePaymentsType::getUrl()),
                Actions\Action::make('employees_payment')
                    ->label('Employee Payment Status')
                    ->url(EmployeePaymentsStatus::getUrl()),
                Actions\Action::make('employees_request')
                    ->label('Employee Requests Status')
                    ->url(EmployeeRequestsStatus::getUrl())
            ])
        ];
    }
}
