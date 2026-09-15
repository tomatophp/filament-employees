<?php

use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages\CreateEmployeeApply;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages\EditEmployeeApply;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages\ListEmployeeApplies;
use TomatoPHP\FilamentEmployees\Models\EmployeeApply;
use TomatoPHP\FilamentEmployees\Tests\Models\User;
use TomatoPHP\FilamentTypes\Models\Type;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());

    Type::query()->create([
        'for' => 'employee_apply',
        'type' => 'status',
        'key' => 'pending',
        'name' => ['en' => 'Pending'],
        'color' => '#f59e0b',
        'icon' => 'heroicon-o-clock',
    ]);
});

function makeEmployeeApply(array $attributes = []): EmployeeApply
{
    return EmployeeApply::query()->create([
        'first_name' => 'Lina',
        'last_name' => 'Farouk',
        'address' => 'Cairo',
        'phone' => '+201000000002',
        'email' => 'lina@example.com',
        'id_number' => '29001011234567',
        'position' => 'Backend Developer',
        ...$attributes,
    ]);
}

it('renders the applies list, create and edit pages', function () {
    $apply = makeEmployeeApply();

    get(EmployeeApplyResource::getUrl())->assertSuccessful();
    get(EmployeeApplyResource::getUrl('create'))->assertSuccessful();
    get(EmployeeApplyResource::getUrl('edit', ['record' => $apply]))->assertSuccessful();
});

it('lists applies', function () {
    $apply = makeEmployeeApply();

    livewire(ListEmployeeApplies::class)
        ->loadTable()
        ->assertCanSeeTableRecords([$apply]);
});

it('creates an apply', function () {
    livewire(CreateEmployeeApply::class)
        ->fillForm([
            'first_name' => 'Karim',
            'last_name' => 'Adel',
            'phone' => '+201000000003',
            'email' => 'karim@example.com',
            'address' => 'Giza',
            'position' => 'Designer',
            'explicated_salary' => 12000,
            'id_number' => '29001011234568',
            'status' => 'pending',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(EmployeeApply::class, ['email' => 'karim@example.com', 'position' => 'Designer']);
});

it('edits an apply', function () {
    $apply = makeEmployeeApply();

    livewire(EditEmployeeApply::class, ['record' => $apply->getRouteKey()])
        ->fillForm([
            'position' => 'Tech Lead',
            'status' => 'pending',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($apply->refresh()->position)->toBe('Tech Lead');
});
