<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use TomatoPHP\FilamentEmployees\Models\EmployeePayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

class EmployeePaymentRelation extends RelationManager
{
    protected static string $relationship = 'employeePayments';

    protected static ?string $title = 'Payments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('date'),
                Forms\Components\Select::make('reason')
                    ->searchable()
                    ->default('reward')
                    ->live()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set){
                        if(str($get('reason'))->contains(['reward', 'bonus', 'payroll'])) {
                            $set('type', 'in');
                        } else {
                            $set('type', 'out');
                        }
                    })
                    ->options(Type::query()->where('for', 'employee_payments')->where('type', 'reason')->pluck('name', 'key')->toArray())
                    ->required(),
                Forms\Components\Select::make('type')
                    ->columnSpanFull()
                    ->searchable()
                    ->required()
                    ->options([
                        'in' => 'In',
                        'out' => 'Out',
                    ])
                    ->default('in'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('status')
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
                Tables\Actions\CreateAction::make()
                    ->using(function (array $data) {
                        $data['user_id'] = auth()->user()->id;
                        $data['account_id'] = $this->getOwnerRecord()->id;

                        $record = EmployeePayment::create($data);
                        return $record;
                    }),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reason')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                TypeColumn::make('status')
                    ->label(trans('Status'))
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_approved'),
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
