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
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use TomatoPHP\FilamentEmployees\Models\EmployeeRequest;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use TomatoPHP\FilamentTypes\Models\Type;

class EmployeeRequestRelation extends RelationManager
{
    protected static string $relationship = 'employeeRequests';

    protected static ?string $title = 'Requests';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('type')
                    ->maxLength(255)
                    ->default('holiday'),
                DateTimePicker::make('from'),
                DateTimePicker::make('to'),
                TextInput::make('amount')
                    ->numeric()
                    ->default(0),
                TextInput::make('total')
                    ->numeric()
                    ->default(0),
                Textarea::make('request_message')
                    ->columnSpanFull(),
                Textarea::make('request_response')
                    ->columnSpanFull(),
                TextInput::make('request_by')
                    ->numeric(),
                Select::make('status')
                    ->searchable()
                    ->required()
                    ->options(Type::query()->where('for', 'employees_request')->where('type', 'status')->pluck('name', 'key')->toArray())
                    ->default('pending'),
                Toggle::make('is_activated'),
                Toggle::make('is_approved'),
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

                        $record = EmployeeRequest::create($data);

                        return $record;
                    }),
            ])
            ->columns([
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('from')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('to')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('request_by')
                    ->numeric()
                    ->sortable(),
                TypeColumn::make('status')
                    ->label(trans('Status'))
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                IconColumn::make('is_activated')
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
}
