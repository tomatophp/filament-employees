<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use TomatoPHP\FilamentEmployees\Models\EmployeePayroll;

class EmployeePayrollRelation extends RelationManager
{
    protected static string $relationship = 'employeePayrolls';

    protected static ?string $title = 'Payrolls';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->required()
                    ->maxLength(4)
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y')),
                TextInput::make('month')
                    ->required()
                    ->maxLength(2)
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(12),
                DateTimePicker::make('date')
                    ->required(),
                TextInput::make('total_time')
                    ->numeric()
                    ->default(0),
                TextInput::make('offs_time')
                    ->numeric()
                    ->default(0),
                TextInput::make('overtime_time')
                    ->numeric()
                    ->default(0),
                TextInput::make('delay_time')
                    ->numeric()
                    ->default(0),
                TextInput::make('out_date_payments')
                    ->numeric()
                    ->default(0),
                TextInput::make('subscription')
                    ->numeric()
                    ->default(0),
                TextInput::make('tax')
                    ->numeric()
                    ->default(0),
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

                        $this->getTotal($data);

                        $record = EmployeePayroll::create($data);

                        return $record;
                    }),
            ])
            ->columns([
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('year')
                    ->searchable(),
                TextColumn::make('month')
                    ->searchable(),
                TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('total_time')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('offs_time')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('overtime_time')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('delay_time')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('out_date_payments')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('subscription')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tax')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total')
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function getTotal(&$data)
    {
        $employee = config('filament-accounts.model')::find($data['account_id']);

        $salary = (float) ($employee?->meta('salary') ?? 0);
        $hour = $salary / 160;
        $total = $data['total_time'] * $hour;
        $overtime_delay = ($data['overtime_time'] - $data['delay_time']) * $hour;
        $total += $overtime_delay;
        $total -= ($data['offs_time'] * 8) * $hour;
        $total += $data['out_date_payments'];
        $total -= $data['subscription'];
        $total -= $data['tax'];

        $data['total'] = $total;
    }
}
