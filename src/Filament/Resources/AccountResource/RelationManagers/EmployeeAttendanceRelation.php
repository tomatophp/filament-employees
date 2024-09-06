<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AccountResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Support\Carbon;
use TomatoPHP\FilamentEmployees\Models\AttendanceShift;
use TomatoPHP\FilamentEmployees\Models\EmployeeAttendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentTypes\Models\Type;

class EmployeeAttendanceRelation extends RelationManager
{
    protected static string $relationship = 'employeeAttendances';

    protected static ?string $title = 'Attendances';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->date()
                    ->default(date('Y-m-d'))
                    ->required(),
                Forms\Components\Select::make('source')
                    ->searchable()
                    ->required()
                    ->options([
                        'fingerprint' => 'Fingerprint',
                        'manual' => 'Manual',
                    ])
                    ->default('manual'),
                Forms\Components\TimePicker::make('in_at')
                    ->time('H:i A')
                    ->required(),
                Forms\Components\TimePicker::make('out_at')
                    ->time('H:i A'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(function (array $data) {
                        $data['user_id'] = auth()->user()->id;
                        $data['account_id'] = $this->getOwnerRecord()->id;
                        $data['department'] = $this->getOwnerRecord()->meta('department');
                        if($data['notes']){
                            $data['notes_by'] = auth()->user()->id;
                        }

                        $this->getTimes($data);

                        $record = EmployeeAttendance::create($data);
                        return $record;
                    }),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('source')
                    ->searchable(),
                Tables\Columns\TextColumn::make('in_at'),
                Tables\Columns\TextColumn::make('out_at'),
                Tables\Columns\TextColumn::make('delay')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('overtime')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('note_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->using(function (array $data, $record) {
                    if($data['notes']){
                        $data['notes_by'] = auth()->user()->id;
                    }

                    $this->getTimes($data);

                    $record->update($data);
                    return $record;
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function getTimes(&$data)
    {
        $total = 0;
        $delay = 0;
        $overtime = 0;
        if(!empty($data['out_at']) && !empty($data['in_at'])){
            $total = Carbon::parse($data['in_at'])->diffInMinutes(Carbon::parse($data['out_at']));
            $attendanceShift = AttendanceShift::find($this->getOwnerRecord()->meta('attendance_shift_id'));
            if($attendanceShift){
                $delay = Carbon::parse($attendanceShift->start_at)->diffInMinutes(Carbon::parse($data['in_at']));
                $overtime = Carbon::parse($attendanceShift->end_at)->diffInMinutes(Carbon::parse($data['out_at']));
            }

            $overTimeInNagtive = ($total/60) - (Carbon::parse($attendanceShift->start_at)->diffInMinutes(Carbon::parse($attendanceShift->end_at))/60);

        }
        $data["total"] = $total/60;
        $data["delay"] = ($delay/60) > 0 ? $delay/60 : 0;
        $data["overtime"] = ($overtime/60) > 0 ? $overtime/60 : ($overTimeInNagtive?:0);
    }
}
