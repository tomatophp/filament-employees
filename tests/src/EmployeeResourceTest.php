<?php

use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EditAccount;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\ListAccounts;
use TomatoPHP\FilamentEmployees\Tests\Models\Account;
use TomatoPHP\FilamentEmployees\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('renders the employees list and edit pages', function () {
    $employee = Account::factory()->create();

    get(EmployeeResource::getUrl())->assertSuccessful();
    get(EmployeeResource::getUrl('edit', ['record' => $employee]))->assertSuccessful();
});

it('lists only employee accounts', function () {
    $employees = Account::factory()->count(2)->create();
    $customer = Account::factory()->create(['type' => 'customer']);

    livewire(ListAccounts::class)
        ->loadTable()
        ->assertCanSeeTableRecords($employees)
        ->assertCanNotSeeTableRecords([$customer]);
});

it('creates an employee account', function () {
    livewire(ListAccounts::class)
        ->callAction('create', data: [
            'name' => 'Omar Khaled',
            'email' => 'omar@example.com',
            'phone' => '+201000000001',
        ])
        ->assertHasNoActionErrors();

    assertDatabaseHas('accounts', [
        'email' => 'omar@example.com',
        'username' => 'omar@example.com',
        'type' => 'employee',
    ]);
});

it('creates an employee account without an email', function () {
    livewire(ListAccounts::class)
        ->callAction('create', data: [
            'name' => 'Sara Mahmoud',
            'phone' => '+201000000004',
        ])
        ->assertHasNoActionErrors();

    assertDatabaseHas('accounts', [
        'name' => 'Sara Mahmoud',
        'username' => '+201000000004',
        'type' => 'employee',
    ]);
});

it('keeps the settings links in the header menu', function () {
    livewire(ListAccounts::class)
        ->assertActionExists('departments')
        ->assertActionExists('employees_payment_reasons')
        ->assertActionExists('employees_payment_status')
        ->assertActionExists('employees_request');
});

it('stores the employee profile as meta', function () {
    $employee = Account::factory()->create();

    livewire(EditAccount::class, ['record' => $employee->getRouteKey()])
        ->fillForm([
            'name' => 'Nour El-Din',
            'position' => 'QA Engineer',
            'salary' => 8000,
            'is_active' => true,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $employee->refresh();

    expect($employee->name)->toBe('Nour El-Din')
        ->and($employee->meta('position'))->toBe('QA Engineer')
        ->and((float) $employee->meta('salary'))->toBe(8000.0);

    livewire(EditAccount::class, ['record' => $employee->getRouteKey()])
        ->assertFormSet([
            'position' => 'QA Engineer',
        ]);
});
