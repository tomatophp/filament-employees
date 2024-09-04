<?php

namespace TomatoPHP\FilamentEmployees\Models;

use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentEmployees\Models\User;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $employee_id
 * @property string $date
 * @property string $reason
 * @property string $type
 * @property string $description
 * @property float $total
 * @property string $status
 * @property boolean $is_approved
 * @property string $created_at
 * @property string $updated_at
 * @property Employee $employee
 * @property User $user
 */
class EmployeePayment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'account_id', 'date', 'reason', 'type', 'description', 'total', 'status', 'is_approved', 'created_at', 'updated_at'];


    protected $casts = [
        "is_approved" => "boolean"
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(config('filament-accounts.model'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
