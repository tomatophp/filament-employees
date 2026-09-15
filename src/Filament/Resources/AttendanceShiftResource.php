<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource\Pages\ListAttendanceShifts;
use TomatoPHP\FilamentEmployees\Models\AttendanceShift;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

class AttendanceShiftResource extends Resource
{
    protected static ?string $model = AttendanceShift::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clock';

    public static function getNavigationGroup(): ?string
    {
        return 'HRMS';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Shifts';
    }

    public static function getLabel(): ?string
    {
        return 'Shift';
    }

    public static function getNavigationLabel(): string
    {
        return 'Shifts';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('department')
                    ->columnSpanFull()
                    ->label('Department')
                    ->searchable()
                    ->live()
                    ->preload()
                    ->options(Type::query()->where('for', 'employees')->where('type', 'departments')->pluck('name', 'key')->toArray())
                    ->nullable(),
                TextInput::make('name')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                TimePicker::make('start_at')
                    ->time('H:i A')
                    ->required(),
                TimePicker::make('end_at')
                    ->time('H:i A')
                    ->required(),
                Toggle::make('is_activated')
                    ->columnSpanFull()
                    ->default(0),
                Repeater::make('offs')
                    ->defaultItems(0)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('start_at')
                            ->options([
                                'sat' => 'Saturday',
                                'sun' => 'Sunday',
                                'mon' => 'Monday',
                                'tue' => 'Tuesday',
                                'wed' => 'Wednesday',
                                'thu' => 'Thursday',
                                'fri' => 'Friday',
                            ])
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TypeColumn::make('department')
                    ->searchable(),
                TextColumn::make('start_at')->time('H:i A'),
                TextColumn::make('end_at')->time('H:i A'),
                ToggleColumn::make('is_activated'),
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttendanceShifts::route('/'),
        ];
    }
}
