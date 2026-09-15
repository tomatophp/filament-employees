<?php

use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages\EmployeeApplyStatus;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\Departments;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EmployeePaymentsStatus;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EmployeePaymentsType;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EmployeeRequestsStatus;
use TomatoPHP\FilamentEmployees\Tests\Models\User;
use TomatoPHP\FilamentTypes\Models\Type;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('renders every settings page', function (string $page) {
    get($page::getUrl())->assertSuccessful();
})->with([
    Departments::class,
    EmployeePaymentsStatus::class,
    EmployeePaymentsType::class,
    EmployeeRequestsStatus::class,
    EmployeeApplyStatus::class,
]);

it('seeds the default payment reasons and statuses', function () {
    get(EmployeePaymentsType::getUrl())->assertSuccessful();
    get(EmployeePaymentsStatus::getUrl())->assertSuccessful();

    assertDatabaseHas(Type::class, ['for' => 'employee_payments', 'type' => 'reason', 'key' => 'reward']);
    assertDatabaseHas(Type::class, ['for' => 'employees_payment', 'type' => 'status', 'key' => 'pending']);
});
