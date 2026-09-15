<?php

namespace TomatoPHP\FilamentEmployees\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use TomatoPHP\FilamentMeta\Traits\HasMeta;

trait IsEmployee
{
    use HasMeta;

    public function employeeAttendances(): HasMany
    {
        return $this->hasMany('TomatoPHP\FilamentEmployees\Models\EmployeeAttendance', 'account_id');
    }

    public function employeePayrolls(): HasMany
    {
        return $this->hasMany('TomatoPHP\FilamentEmployees\Models\EmployeePayroll', 'account_id');

    }

    public function employeeRequests(): HasMany
    {
        return $this->hasMany('TomatoPHP\FilamentEmployees\Models\EmployeeRequest', 'account_id');

    }

    public function employeePayments(): HasMany
    {
        return $this->hasMany('TomatoPHP\FilamentEmployees\Models\EmployeePayment', 'account_id');
    }
}
