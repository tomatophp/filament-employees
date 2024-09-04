<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\AccountResource\RelationManagers;

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
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('account_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('year')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('month')
                    ->required()
                    ->maxLength(255),
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
                Forms\Components\TextInput::make('total')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\CreateAction::make()
            ])
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account_id')
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
}
