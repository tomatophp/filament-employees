<?php

namespace TomatoPHP\FilamentEmployees\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait IsEmployee
{

    /**
     * @return HasMany
     */
    public function employeeAttendances(): HasMany
    {
        return $this->hasMany('TomatoPHP\FilamentEmployees\Models\EmployeeAttendance', 'account_id');
    }

    /**
     * @return HasMany
     */
    public function employeePayrolls(): HasMany
    {
        return $this->hasMany('TomatoPHP\FilamentEmployees\Models\EmployeePayroll', 'account_id');

    }

    /**
     * @return HasMany
     */
    public function employeeRequests(): HasMany
    {
        return $this->hasMany('TomatoPHP\FilamentEmployees\Models\EmployeeRequest', 'account_id');

    }

    /**
     * @return HasMany
     */
    public function employeePayments(): HasMany
    {
        return $this->hasMany('TomatoPHP\FilamentEmployees\Models\EmployeePayment', 'account_id');
    }
}
