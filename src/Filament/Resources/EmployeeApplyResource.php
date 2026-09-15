<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages\CreateEmployeeApply;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages\EditEmployeeApply;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages\ListEmployeeApplies;
use TomatoPHP\FilamentEmployees\Models\EmployeeApply;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

class EmployeeApplyResource extends Resource
{
    protected static ?string $model = EmployeeApply::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cube-transparent';

    public static function getNavigationGroup(): ?string
    {
        return 'HRMS';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Applies';
    }

    public static function getLabel(): ?string
    {
        return 'Apply';
    }

    public static function getNavigationLabel(): string
    {
        return 'Applies';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema

            ->components([
                Grid::make([
                    'md' => 12,
                    'sm' => 1,
                ])->columnSpanFull()->schema([
                    Grid::make(1)
                        ->schema([
                            Section::make('Personal Information')
                                ->schema([
                                    TextInput::make('first_name')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('last_name')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('phone')
                                        ->tel()
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('email')
                                        ->email()
                                        ->required()
                                        ->maxLength(255),
                                    DatePicker::make('birthday'),
                                    Textarea::make('address')
                                        ->columnSpanFull(),
                                ])->columns(2),
                            Section::make('Job Details')
                                ->schema([
                                    TextInput::make('position')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('explicated_salary')
                                        ->required()
                                        ->numeric()
                                        ->default(0),
                                    DatePicker::make('start_at'),
                                    Select::make('id_type')
                                        ->searchable()
                                        ->options([
                                            'national' => 'National ID',
                                            'id' => 'ID',
                                            'passport' => 'Passport',
                                            'visa' => 'Visa',
                                        ])
                                        ->default('national'),
                                    TextInput::make('id_number')
                                        ->numeric(),
                                    Textarea::make('hr_cover_letter')
                                        ->columnSpanFull(),
                                ])->columns(3),
                            Section::make('Education')
                                ->schema([
                                    Select::make('education_type')
                                        ->default('university')
                                        ->options([
                                            'school' => 'School',
                                            'university' => 'University',
                                            'college' => 'College',
                                        ]),
                                    TextInput::make('university'),
                                    TextInput::make('college'),
                                    TextInput::make('department'),
                                ])->columns(2),
                        ])
                        ->columnSpan(8),
                    Grid::make(1)
                        ->schema([
                            Section::make('Status')
                                ->schema([
                                    Select::make('status')
                                        ->searchable()
                                        ->required()
                                        ->options(Type::query()->where('for', 'employee_apply')->where('type', 'status')->pluck('name', 'key')->toArray())
                                        ->default('pending'),
                                    Toggle::make('is_activated'),
                                    Toggle::make('ready_for_interview'),
                                ]),
                            Section::make('Approval')
                                ->schema([
                                    Toggle::make('hr_approved')
                                        ->live()
                                        ->default(false),
                                    Select::make('hr_approved_by')
                                        ->visible(fn (Get $get) => $get('hr_approved'))
                                        ->searchable()
                                        ->required()
                                        ->options(config('auth.providers.users.model')::query()->pluck('name', 'id')->toArray()),
                                    Textarea::make('hr_notes')
                                        ->visible(fn (Get $get) => $get('hr_approved'))
                                        ->columnSpanFull(),
                                    Toggle::make('tech_approved')
                                        ->live()
                                        ->default(false),
                                    Select::make('tech_approved_by')
                                        ->visible(fn (Get $get) => $get('tech_approved'))
                                        ->searchable()
                                        ->required()
                                        ->options(config('auth.providers.users.model')::query()->pluck('name', 'id')->toArray()),
                                    Textarea::make('tech_notes')
                                        ->visible(fn (Get $get) => $get('tech_approved'))
                                        ->columnSpanFull(),
                                    Toggle::make('is_approved')
                                        ->live()
                                        ->default(false),
                                    Select::make('is_approved_by')
                                        ->visible(fn (Get $get) => $get('is_approved'))
                                        ->searchable()
                                        ->required()
                                        ->options(config('auth.providers.users.model')::query()->pluck('name', 'id')->toArray()),
                                ]),
                            Section::make('Insurance')
                                ->schema([
                                    Toggle::make('has_insurance')
                                        ->default(false)
                                        ->live(),
                                    TextInput::make('insurance_number')
                                        ->visible(fn (Get $get) => $get('has_insurance'))
                                        ->required()
                                        ->maxLength(255),
                                ]),
                        ])
                        ->columnSpan(4),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('position')
                    ->searchable(),
                TypeColumn::make('status')
                    ->label(trans('Status'))
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('start_at')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_activated')
                    ->boolean(),
                IconColumn::make('ready_for_interview')
                    ->boolean(),
                IconColumn::make('hr_approved')
                    ->boolean(),
                IconColumn::make('tech_approved')
                    ->boolean(),
                IconColumn::make('is_approved')
                    ->boolean(),
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
            'index' => ListEmployeeApplies::route('/'),
            'create' => CreateEmployeeApply::route('/create'),
            'edit' => EditEmployeeApply::route('/{record}/edit'),
        ];
    }
}
