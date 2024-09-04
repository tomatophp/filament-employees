<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources;

use TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource\Pages;
use TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource\RelationManagers;
use TomatoPHP\FilamentEmployees\Models\AttendanceShift;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

class AttendanceShiftResource extends Resource
{
    protected static ?string $model = AttendanceShift::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function getNavigationGroup(): ?string
    {
        return "HRMS";
    }

    public static function getPluralLabel(): ?string
    {
        return "Shifts";
    }

    public static function getLabel(): ?string
    {
        return "Shift";
    }

    public static function getNavigationLabel(): string
    {
        return "Shifts";
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('department')
                    ->columnSpanFull()
                    ->label('Department')
                    ->searchable()
                    ->live()
                    ->preload()
                    ->options(Type::query()->where('for', 'employees')->where('type', 'departments')->pluck('name', 'key')->toArray())
                    ->nullable(),
                Forms\Components\TextInput::make('name')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TimePicker::make('start_at')
                    ->time('H:i A')
                    ->required(),
                Forms\Components\TimePicker::make('end_at')
                    ->time('H:i A')
                    ->required(),
                Forms\Components\Toggle::make('is_activated')
                    ->columnSpanFull()
                    ->default(0),
                Forms\Components\Repeater::make('offs')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\Select::make('start_at')
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                TypeColumn::make('department')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_at')->time('H:i A'),
                Tables\Columns\TextColumn::make('end_at')->time('H:i A'),
                Tables\Columns\ToggleColumn::make('is_activated'),
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAttendanceShifts::route('/')
        ];
    }
}
