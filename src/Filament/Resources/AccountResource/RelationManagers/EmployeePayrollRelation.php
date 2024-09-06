<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AccountResource\RelationManagers;

use App\Models\Account;
use Filament\Resources\RelationManagers\RelationManager;
use TomatoPHP\FilamentEmployees\Models\EmployeePayroll;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeePayrollRelation extends RelationManager
{
    protected static string $relationship = 'employeePayrolls';

    protected static ?string $title = 'Payrolls';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('year')
                    ->required()
                    ->maxLength(4)
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y')),
                Forms\Components\TextInput::make('month')
                    ->required()
                    ->maxLength(2)
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(12),
                Forms\Components\DateTimePicker::make('date')
                    ->required(),
                Forms\Components\TextInput::make('total_time')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('offs_time')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('overtime_time')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('delay_time')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('out_date_payments')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('subscription')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('tax')
                    ->numeric()
                    ->default(0),
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

                        $this->getTotal($data);

                        $record = EmployeePayroll::create($data);
                        return $record;
                    }),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')
                    ->searchable(),
                Tables\Columns\TextColumn::make('month')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_time')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('offs_time')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('overtime_time')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delay_time')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('out_date_payments')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subscription')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tax')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
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

    public function getTotal(&$data)
    {
        $employee = Account::find($data['account_id']);

        $salary = $employee->salary;
        $hour = $salary / 160;
        $total = $data['total_time'] * $hour;
        $overtime_delay = ($data['overtime_time'] - $data['delay_time']) * $hour;
        $total += $overtime_delay;
        $total -= ($data['offs_time'] * 8) * $hour;
        $total += $data['out_date_payments'];
        $total -= $data['subscription'];
        $total -= $data['tax'];

        $data["total"] = $total;
    }
}
