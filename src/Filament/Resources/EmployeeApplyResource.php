<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources;

use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\RelationManagers;
use TomatoPHP\FilamentEmployees\Models\EmployeeApply;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeApplyResource extends Resource
{
    protected static ?string $model = EmployeeApply::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    public static function getNavigationGroup(): ?string
    {
        return "HRMS";
    }

    public static function getPluralLabel(): ?string
    {
        return "Applies";
    }

    public static function getLabel(): ?string
    {
        return "Apply";
    }

    public static function getNavigationLabel(): string
    {
        return "Applies";
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birthday'),
                Forms\Components\TextInput::make('id_type')
                    ->required()
                    ->maxLength(255)
                    ->default('national'),
                Forms\Components\TextInput::make('id_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('education_type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('university')
                    ->maxLength(255),
                Forms\Components\TextInput::make('college')
                    ->maxLength(255),
                Forms\Components\TextInput::make('department')
                    ->maxLength(255),
                Forms\Components\TextInput::make('position')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('hr_cover_letter')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('has_insurance')
                    ->required(),
                Forms\Components\TextInput::make('insurance_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('explicated_salary')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\DatePicker::make('start_at'),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('pending'),
                Forms\Components\Textarea::make('hr_notes')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('tech_notes')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_activated'),
                Forms\Components\Toggle::make('ready_for_interview'),
                Forms\Components\Toggle::make('hr_approved'),
                Forms\Components\TextInput::make('hr_approved_by')
                    ->numeric(),
                Forms\Components\Toggle::make('tech_approved'),
                Forms\Components\TextInput::make('tech_approved_by')
                    ->numeric(),
                Forms\Components\Toggle::make('is_approved'),
                Forms\Components\TextInput::make('is_approved_by')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birthday')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('id_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('education_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('university')
                    ->searchable(),
                Tables\Columns\TextColumn::make('college')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department')
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->searchable(),
                Tables\Columns\IconColumn::make('has_insurance')
                    ->boolean(),
                Tables\Columns\TextColumn::make('insurance_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('explicated_salary')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_activated')
                    ->boolean(),
                Tables\Columns\IconColumn::make('ready_for_interview')
                    ->boolean(),
                Tables\Columns\IconColumn::make('hr_approved')
                    ->boolean(),
                Tables\Columns\TextColumn::make('hr_approved_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('tech_approved')
                    ->boolean(),
                Tables\Columns\TextColumn::make('tech_approved_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean(),
                Tables\Columns\TextColumn::make('is_approved_by')
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
            'index' => Pages\ListEmployeeApplies::route('/'),
            'create' => Pages\CreateEmployeeApply::route('/create'),
            'edit' => Pages\EditEmployeeApply::route('/{record}/edit'),
        ];
    }
}
