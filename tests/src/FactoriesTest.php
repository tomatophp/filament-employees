<?php

use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeApplyResource\Pages\EditEmployeeApply;
use TomatoPHP\FilamentEmployees\Models\AttendanceShift;
use TomatoPHP\FilamentEmployees\Models\EmployeeApply;
use TomatoPHP\FilamentEmployees\Tests\Models\User;
use TomatoPHP\FilamentTypes\Models\Type;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('creates shifts and applies from the package factories', function () {
    $shift = AttendanceShift::factory()->create();
    $apply = EmployeeApply::factory()->create();

    expect($shift->offs)->toBe([['start_at' => 'fri']])
        ->and($apply->id_type)->toBe('national');
});

it('saves an apply that uses the national id type', function () {
    actingAs(User::factory()->create());

    Type::query()->create([
        'for' => 'employee_apply',
        'type' => 'status',
        'key' => 'pending',
        'name' => ['en' => 'Pending'],
        'color' => '#f59e0b',
        'icon' => 'heroicon-o-clock',
    ]);

    $apply = EmployeeApply::factory()->create();

    livewire(EditEmployeeApply::class, ['record' => $apply->getRouteKey()])
        ->fillForm(['position' => 'Team Lead'])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($apply->refresh())
        ->position->toBe('Team Lead')
        ->id_type->toBe('national');
});
