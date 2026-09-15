<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource;

class ListAccounts extends ManageRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    // The accounts username is required and unique; the form only fills it from a typed email.
                    $data['type'] = 'employee';
                    $data['username'] = collect([$data['username'] ?? null, $data['email'] ?? null, $data['phone'] ?? null])
                        ->first(fn ($value) => filled($value))
                        ?? str($data['name'] ?? '')->slug()->toString();

                    return $data;
                }),
            ActionGroup::make([
                Action::make('departments')
                    ->label('Departments')
                    ->url(Departments::getUrl()),
                Action::make('employees_payment_reasons')
                    ->label('Employee Payment Reasons')
                    ->url(EmployeePaymentsType::getUrl()),
                Action::make('employees_payment_status')
                    ->label('Employee Payment Status')
                    ->url(EmployeePaymentsStatus::getUrl()),
                Action::make('employees_request')
                    ->label('Employee Requests Status')
                    ->url(EmployeeRequestsStatus::getUrl()),
            ]),
        ];
    }
}
