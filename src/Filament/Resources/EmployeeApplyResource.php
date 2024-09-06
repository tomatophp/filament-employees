<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources;

use App\Models\User;
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
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

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
                Forms\Components\Grid::make([
                    'md' => 12,
                    'sm' => 1
                ])->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Section::make('Personal Information')
                                ->schema([
                                    Forms\Components\TextInput::make('first_name')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('last_name')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('phone')
                                        ->tel()
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('email')
                                        ->email()
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\DatePicker::make('birthday'),
                                    Forms\Components\Textarea::make('address')
                                        ->columnSpanFull(),
                                ])->columns(2),
                            Forms\Components\Section::make('Job Details')
                                ->schema([
                                    Forms\Components\TextInput::make('position')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('explicated_salary')
                                        ->required()
                                        ->numeric()
                                        ->default(0),
                                    Forms\Components\DatePicker::make('start_at'),
                                    Forms\Components\Select::make('id_type')
                                        ->searchable()
                                        ->options([
                                            'id' => 'ID',
                                            'passport' => 'Passport',
                                            'visa' => 'Visa',
                                        ])
                                        ->default('id'),
                                    Forms\Components\TextInput::make('id_number')
                                        ->numeric(),
                                    Forms\Components\Textarea::make('hr_cover_letter')
                                        ->columnSpanFull(),
                                ])->columns(3),
                            Forms\Components\Section::make('Education')
                                ->schema([
                                    Forms\Components\Select::make('education_type')
                                        ->default('university')
                                        ->options([
                                            'school' => 'School',
                                            'university' => 'University',
                                            'college' => 'College',
                                        ]),
                                    Forms\Components\TextInput::make('university'),
                                    Forms\Components\TextInput::make('college'),
                                    Forms\Components\TextInput::make('department'),
                                ])->columns(2),
                        ])
                        ->columnSpan(8),
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Section::make('Status')
                                ->schema([
                                    Forms\Components\Select::make('status')
                                        ->searchable()
                                        ->required()
                                        ->options(Type::query()->where('for', 'employee_apply')->where('type', 'status')->pluck('name', 'key')->toArray())
                                        ->default('pending'),
                                    Forms\Components\Toggle::make('is_activated'),
                                    Forms\Components\Toggle::make('ready_for_interview'),
                                ]),
                            Forms\Components\Section::make('Approval')
                                ->schema([
                                    Forms\Components\Toggle::make('hr_approved')
                                        ->live()
                                        ->default(false),
                                    Forms\Components\Select::make('hr_approved_by')
                                        ->visible(fn(Forms\Get $get) => $get('hr_approved'))
                                        ->searchable()
                                        ->required()
                                        ->options(User::query()->pluck('name', 'id')->toArray()),
                                    Forms\Components\Textarea::make('hr_notes')
                                        ->visible(fn(Forms\Get $get) => $get('hr_approved'))
                                        ->columnSpanFull(),
                                    Forms\Components\Toggle::make('tech_approved')
                                        ->live()
                                        ->default(false),
                                    Forms\Components\Select::make('tech_approved_by')
                                        ->visible(fn(Forms\Get $get) => $get('tech_approved'))
                                        ->searchable()
                                        ->required()
                                        ->options(User::query()->pluck('name', 'id')->toArray()),
                                    Forms\Components\Textarea::make('tech_notes')
                                        ->visible(fn(Forms\Get $get) => $get('tech_approved'))
                                        ->columnSpanFull(),
                                    Forms\Components\Toggle::make('is_approved')
                                        ->live()
                                        ->default(false),
                                    Forms\Components\Select::make('is_approved_by')
                                        ->visible(fn(Forms\Get $get) => $get('is_approved'))
                                        ->searchable()
                                        ->required()
                                        ->options(User::query()->pluck('name', 'id')->toArray()),
                                ]),
                            Forms\Components\Section::make('Insurance')
                                ->schema([
                                    Forms\Components\Toggle::make('has_insurance')
                                        ->default(false)
                                        ->live(),
                                    Forms\Components\TextInput::make('insurance_number')
                                        ->visible(fn(Forms\Get $get) => $get('has_insurance'))
                                        ->required()
                                        ->maxLength(255),
                                ]),
                        ])
                        ->columnSpan(4),
                ])
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
                Tables\Columns\TextColumn::make('position')
                    ->searchable(),
                TypeColumn::make('status')
                    ->label(trans('Status'))
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_activated')
                    ->boolean(),
                Tables\Columns\IconColumn::make('ready_for_interview')
                    ->boolean(),
                Tables\Columns\IconColumn::make('hr_approved')
                    ->boolean(),
                Tables\Columns\IconColumn::make('tech_approved')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean(),
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
