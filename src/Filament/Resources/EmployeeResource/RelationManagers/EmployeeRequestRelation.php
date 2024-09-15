<?php

namespace TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use TomatoPHP\FilamentEmployees\Models\EmployeeRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

class EmployeeRequestRelation extends RelationManager
{
    protected static string $relationship = 'employeeRequests';

    protected static ?string $title = 'Requests';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')
                    ->maxLength(255)
                    ->default('holiday'),
                Forms\Components\DateTimePicker::make('from'),
                Forms\Components\DateTimePicker::make('to'),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('total')
                    ->numeric()
                    ->default(0),
                Forms\Components\Textarea::make('request_message')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('request_response')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('request_by')
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->searchable()
                    ->required()
                    ->options(Type::query()->where('for', 'employees_request')->where('type', 'status')->pluck('name', 'key')->toArray())
                    ->default('pending'),
                Forms\Components\Toggle::make('is_activated'),
                Forms\Components\Toggle::make('is_approved'),
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

                        $record = EmployeeRequest::create($data);
                        return $record;
                    }),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('from')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('to')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('request_by')
                    ->numeric()
                    ->sortable(),
                TypeColumn::make('status')
                    ->label(trans('Status'))
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_activated')
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
}
