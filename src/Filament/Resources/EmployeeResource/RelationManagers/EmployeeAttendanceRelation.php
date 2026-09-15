<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use TomatoPHP\FilamentEmployees\Models\AttendanceShift;
use TomatoPHP\FilamentEmployees\Models\EmployeeAttendance;

class EmployeeAttendanceRelation extends RelationManager
{
    protected static string $relationship = 'employeeAttendances';

    protected static ?string $title = 'Attendances';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->date()
                    ->default(date('Y-m-d'))
                    ->required(),
                Select::make('source')
                    ->searchable()
                    ->required()
                    ->options([
                        'fingerprint' => 'Fingerprint',
                        'manual' => 'Manual',
                    ])
                    ->default('manual'),
                TimePicker::make('in_at')
                    ->time('H:i A')
                    ->required(),
                TimePicker::make('out_at')
                    ->minDate(fn (Get $get) => Carbon::parse($get('in_at'))->addHour()->toTimeString())
                    ->time('H:i A'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->using(function (array $data) {
                        $data['user_id'] = auth()->user()->id;
                        $data['account_id'] = $this->getOwnerRecord()->id;
                        $data['department'] = $this->getOwnerRecord()->meta('department') ?? '';
                        if (! empty($data['notes'])) {
                            $data['note_by'] = auth()->user()->id;
                        }

                        $this->getTimes($data);

                        $record = EmployeeAttendance::create($data);

                        return $record;
                    }),
            ])
            ->columns([
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('department')
                    ->searchable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('source')
                    ->searchable(),
                TextColumn::make('in_at'),
                TextColumn::make('out_at'),
                TextColumn::make('delay')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('overtime')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('note_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->using(function (array $data, $record) {
                    if (! empty($data['notes'])) {
                        $data['note_by'] = auth()->user()->id;
                    }

                    $this->getTimes($data);

                    $record->update($data);

                    return $record;
                }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function getTimes(&$data)
    {
        $total = 0;
        $delay = 0;
        $overtime = 0;
        $overTimeInNagtive = 0;
        if (! empty($data['out_at']) && ! empty($data['in_at'])) {
            $total = Carbon::parse($data['in_at'])->diffInMinutes(Carbon::parse($data['out_at']));
            $attendanceShift = AttendanceShift::find($this->getOwnerRecord()->meta('attendance_shift_id'));
            if ($attendanceShift) {
                $delay = Carbon::parse($attendanceShift->start_at)->diffInMinutes(Carbon::parse($data['in_at']));
                $overtime = Carbon::parse($attendanceShift->end_at)->diffInMinutes(Carbon::parse($data['out_at']));
                $overTimeInNagtive = ($total / 60) - (Carbon::parse($attendanceShift->start_at)->diffInMinutes(Carbon::parse($attendanceShift->end_at)) / 60);
            }

        }
        $data['total'] = $total / 60;
        $data['delay'] = $delay > 0 ? (($delay / 60) > 0 ? $delay / 60 : 0) : 0;
        $data['overtime'] = $overtime > 0 ? (($overtime / 60) > 0 ? $overtime / 60 : ($overTimeInNagtive ?: 0)) : 0;
    }
}
