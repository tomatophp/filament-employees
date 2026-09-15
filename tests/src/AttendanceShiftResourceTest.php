<?php

use Filament\Actions\Testing\TestAction;
use TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource;
use TomatoPHP\FilamentEmployees\Filament\Resources\AttendanceShiftResource\Pages\ListAttendanceShifts;
use TomatoPHP\FilamentEmployees\Models\AttendanceShift;
use TomatoPHP\FilamentEmployees\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('renders the shifts page', function () {
    get(AttendanceShiftResource::getUrl())->assertSuccessful();
});

it('creates a shift', function () {
    livewire(ListAttendanceShifts::class)
        ->callAction('create', data: [
            'name' => 'Morning',
            'start_at' => '09:00',
            'end_at' => '17:00',
            'is_activated' => true,
        ])
        ->assertHasNoActionErrors();

    assertDatabaseHas(AttendanceShift::class, ['name' => 'Morning']);
});

it('creates a shift with days off', function () {
    livewire(ListAttendanceShifts::class)
        ->mountAction('create')
        ->fillForm([
            'name' => 'Weekend Off',
            'start_at' => '09:00',
            'end_at' => '17:00',
            'offs' => [
                ['start_at' => 'fri'],
                ['start_at' => 'sat'],
            ],
        ])
        ->callMountedAction()
        ->assertHasNoActionErrors();

    expect(AttendanceShift::query()->where('name', 'Weekend Off')->sole()->offs)
        ->toHaveCount(2);
});

it('validates the shift name', function () {
    livewire(ListAttendanceShifts::class)
        ->callAction('create', data: [
            'name' => null,
            'start_at' => '09:00',
            'end_at' => '17:00',
        ])
        ->assertHasActionErrors(['name' => 'required']);
});

it('edits a shift', function () {
    $shift = AttendanceShift::query()->create([
        'name' => 'Morning',
        'start_at' => '09:00:00',
        'end_at' => '17:00:00',
    ]);

    livewire(ListAttendanceShifts::class)
        ->loadTable()
        ->assertCanSeeTableRecords([$shift])
        ->callAction(TestAction::make('edit')->table($shift), data: [
            'name' => 'Evening',
            'start_at' => '14:00',
            'end_at' => '22:00',
        ])
        ->assertHasNoActionErrors();

    expect($shift->refresh()->name)->toBe('Evening');
});
