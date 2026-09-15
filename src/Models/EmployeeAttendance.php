<?php

namespace TomatoPHP\FilamentEmployees\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $employee_id
 * @property int $department_id
 * @property int $note_by
 * @property string $date
 * @property string $source
 * @property string $in_at
 * @property string $out_at
 * @property float $delay
 * @property float $overtime
 * @property float $total
 * @property string $notes
 * @property string $created_at
 * @property string $updated_at
 * @property Department $department
 * @property Employee $employee
 * @property User $noteBy
 * @property User $user
 */
class EmployeeAttendance extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'account_id', 'department', 'note_by', 'date', 'source', 'in_at', 'out_at', 'delay', 'overtime', 'total', 'notes', 'created_at', 'updated_at'];

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
    public function noteBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'note_by');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
