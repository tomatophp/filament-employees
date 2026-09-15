<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource;

class ListAttendanceShifts extends ManageRecords
{
    protected static string $resource = AttendanceShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
