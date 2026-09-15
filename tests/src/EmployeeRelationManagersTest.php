<?php

use Filament\Actions\Testing\TestAction;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EditAccount;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EmployeePaymentsStatus;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\Pages\EmployeePaymentsType;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\RelationManagers\EmployeeAttendanceRelation;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\RelationManagers\EmployeePaymentRelation;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\RelationManagers\EmployeePayrollRelation;
use TomatoPHP\FilamentEmployees\Filament\Resources\EmployeeResource\RelationManagers\EmployeeRequestRelation;
use TomatoPHP\FilamentEmployees\Models\AttendanceShift;
use TomatoPHP\FilamentEmployees\Models\EmployeeAttendance;
use TomatoPHP\FilamentEmployees\Models\EmployeePayment;
use TomatoPHP\FilamentEmployees\Models\EmployeePayroll;
use TomatoPHP\FilamentEmployees\Models\EmployeeRequest;
use TomatoPHP\FilamentEmployees\Tests\Models\Account;
use TomatoPHP\FilamentEmployees\Tests\Models\User;
use TomatoPHP\FilamentTypes\Models\Type;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    actingAs($this->user);

    $this->employee = Account::factory()->create();
});

function relationManager(string $class, Account $employee)
{
    return livewire($class, [
        'ownerRecord' => $employee,
        'pageClass' => EditAccount::class,
    ]);
}

it('renders every relation manager', function (string $class) {
    relationManager($class, $this->employee)->assertSuccessful();
})->with([
    EmployeeAttendanceRelation::class,
    EmployeePaymentRelation::class,
    EmployeeRequestRelation::class,
    EmployeePayrollRelation::class,
]);

it('records an attendance for an employee without a shift or department', function () {
    relationManager(EmployeeAttendanceRelation::class, $this->employee)
        ->callAction(TestAction::make('create')->table(), data: [
            'date' => now()->toDateString(),
            'source' => 'manual',
            'in_at' => '09:00',
            'out_at' => '17:00',
            'notes' => 'Worked from the office',
        ])
        ->assertHasNoFormErrors();

    $attendance = EmployeeAttendance::query()->where('account_id', $this->employee->id)->sole();

    expect((float) $attendance->total)->toBe(8.0)
        ->and((float) $attendance->delay)->toBe(0.0)
        ->and($attendance->note_by)->toBe($this->user->id);
});

it('calculates delay and overtime from the employee shift', function () {
    $shift = AttendanceShift::query()->create([
        'name' => 'Morning',
        'department' => 'engineering',
        'start_at' => '09:00:00',
        'end_at' => '17:00:00',
    ]);

    $this->employee->meta('department', 'engineering');
    $this->employee->meta('attendance_shift_id', $shift->id);

    relationManager(EmployeeAttendanceRelation::class, $this->employee)
        ->callAction(TestAction::make('create')->table(), data: [
            'date' => now()->toDateString(),
            'source' => 'fingerprint',
            'in_at' => '09:30',
            'out_at' => '18:00',
        ])
        ->assertHasNoFormErrors();

    $attendance = EmployeeAttendance::query()->where('account_id', $this->employee->id)->sole();

    expect($attendance->department)->toBe('engineering')
        ->and((float) $attendance->total)->toBe(8.5)
        ->and((float) $attendance->delay)->toBe(0.5)
        ->and((float) $attendance->overtime)->toBe(1.0);
});

it('records a payment', function () {
    // Visiting the settings pages seeds the default reasons and statuses.
    get(EmployeePaymentsType::getUrl())->assertSuccessful();
    get(EmployeePaymentsStatus::getUrl())->assertSuccessful();

    relationManager(EmployeePaymentRelation::class, $this->employee)
        ->callAction(TestAction::make('create')->table(), data: [
            'date' => now()->toDateTimeString(),
            'reason' => 'bonus',
            'type' => 'in',
            'total' => 1500,
            'status' => 'pending',
        ])
        ->assertHasNoFormErrors();

    expect(EmployeePayment::query()->where('account_id', $this->employee->id)->sole())
        ->reason->toBe('bonus')
        ->user_id->toBe($this->user->id);
});

it('records a request', function () {
    Type::query()->create([
        'for' => 'employees_request',
        'type' => 'status',
        'key' => 'pending',
        'name' => ['en' => 'Pending'],
        'color' => '#f59e0b',
        'icon' => 'heroicon-o-clock',
    ]);

    relationManager(EmployeeRequestRelation::class, $this->employee)
        ->callAction(TestAction::make('create')->table(), data: [
            'type' => 'holiday',
            'from' => now()->addDay()->toDateTimeString(),
            'to' => now()->addDays(3)->toDateTimeString(),
            'amount' => 2,
            'status' => 'pending',
        ])
        ->assertHasNoFormErrors();

    expect(EmployeeRequest::query()->where('account_id', $this->employee->id)->sole()->type)->toBe('holiday');
});

it('calculates a payroll from the employee salary', function () {
    $this->employee->meta('salary', 8000);

    relationManager(EmployeePayrollRelation::class, $this->employee)
        ->callAction(TestAction::make('create')->table(), data: [
            'year' => now()->year,
            'month' => 1,
            'date' => now()->toDateTimeString(),
            'total_time' => 160,
            'offs_time' => 0,
            'overtime_time' => 0,
            'delay_time' => 0,
            'out_date_payments' => 0,
            'subscription' => 0,
            'tax' => 0,
        ])
        ->assertHasNoFormErrors();

    expect((float) EmployeePayroll::query()->where('account_id', $this->employee->id)->sole()->total)->toBe(8000.0);
});
