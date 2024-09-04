<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendanceShifts extends ManageRecords
{
    protected static string $resource = AttendanceShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
