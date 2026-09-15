<?php

namespace TomatoPHP\FilamentEmployees\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $employee_id
 * @property string $year
 * @property string $month
 * @property string $date
 * @property float $total_time
 * @property float $offs_time
 * @property float $overtime_time
 * @property float $delay_time
 * @property float $out_date_payments
 * @property float $subscription
 * @property float $tax
 * @property float $total
 * @property string $created_at
 * @property string $updated_at
 * @property Employee $employee
 * @property User $user
 */
class EmployeePayroll extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'account_id', 'year', 'month', 'date', 'total_time', 'offs_time', 'overtime_time', 'delay_time', 'out_date_payments', 'subscription', 'tax', 'total', 'created_at', 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(config('filament-accounts.model'));
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
