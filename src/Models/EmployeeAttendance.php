<?php

namespace TomatoPHP\FilamentEmployees\Models;

use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentEmployees\Models\User;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $employee_id
 * @property integer $department_id
 * @property integer $note_by
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(config('filament-accounts.model'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function noteBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'note_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
