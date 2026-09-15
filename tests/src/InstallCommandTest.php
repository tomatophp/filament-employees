<?php

use Illuminate\Support\Facades\Schema;

it('runs the install command', function () {
    $this->artisan('filament-employees:install')
        ->expectsOutput('Filament Employees installed successfully.')
        ->assertSuccessful();

    expect(Schema::hasTable('employee_attendances'))->toBeTrue()
        ->and(Schema::hasTable('employee_applies'))->toBeTrue();
});
