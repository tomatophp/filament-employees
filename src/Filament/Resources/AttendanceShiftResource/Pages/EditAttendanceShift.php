<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource;

class EditAttendanceShift extends EditRecord
{
    protected static string $resource = AttendanceShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
