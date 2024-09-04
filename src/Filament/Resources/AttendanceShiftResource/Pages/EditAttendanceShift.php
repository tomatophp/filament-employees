<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource\Pages;

use TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttendanceShift extends EditRecord
{
    protected static string $resource = AttendanceShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
