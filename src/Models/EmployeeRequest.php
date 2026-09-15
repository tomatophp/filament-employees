<?php

namespace TomatoPHP\FilamentEmployees\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $employee_id
 * @property int $user_id
 * @property int $request_by
 * @property string $type
 * @property string $from
 * @property string $to
 * @property float $total
 * @property string $request_message
 * @property string $request_response
 * @property string $status
 * @property bool $is_activated
 * @property bool $is_approved
 * @property string $created_at
 * @property string $updated_at
 * @property Employee $employee
 * @property User $requestBy
 * @property User $user
 */
class EmployeeRequest extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['account_id', 'user_id', 'amount', 'request_by', 'type', 'from', 'to', 'total', 'request_message', 'request_response', 'status', 'is_activated', 'is_approved', 'created_at', 'updated_at'];

    protected $casts = [
        'from' => 'date',
        'to' => 'date',
        'is_activated' => 'boolean',
        'is_approved' => 'boolean',
    ];

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
    public function requestBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'request_by');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
