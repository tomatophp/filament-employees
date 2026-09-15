<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use TomatoPHP\FilamentEmployees\Models\EmployeePayment;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

class EmployeePaymentRelation extends RelationManager
{
    protected static string $relationship = 'employeePayments';

    protected static ?string $title = 'Payments';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('date'),
                Select::make('reason')
                    ->searchable()
                    ->default('reward')
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        if (str($get('reason'))->contains(['reward', 'bonus', 'payroll'])) {
                            $set('type', 'in');
                        } else {
                            $set('type', 'out');
                        }
                    })
                    ->options(Type::query()->where('for', 'employee_payments')->where('type', 'reason')->pluck('name', 'key')->toArray())
                    ->required(),
                Select::make('type')
                    ->columnSpanFull()
                    ->searchable()
                    ->required()
                    ->options([
                        'in' => 'In',
                        'out' => 'Out',
                    ])
                    ->default('in'),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('status')
                    ->searchable()
                    ->required()
                    ->options(Type::query()->where('for', 'employees_payment')->where('type', 'status')->pluck('name', 'key')->toArray())
                    ->default('pending'),
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

                        $record = EmployeePayment::create($data);

                        return $record;
                    }),
            ])
            ->columns([
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('reason')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                TypeColumn::make('status')
                    ->label(trans('Status'))
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('is_approved'),
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
}
