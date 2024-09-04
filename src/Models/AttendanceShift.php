<?php

namespace TomatoPHP\FilamentEmployees\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $department_id
 * @property string $name
 * @property string $type
 * @property string $start_at
 * @property string $end_at
 * @property mixed $offs
 * @property boolean $is_activated
 * @property string $created_at
 * @property string $updated_at
 * @property Department $department
 * @property Employee[] $employees
 */
class AttendanceShift extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['department', 'name', 'type', 'start_at', 'end_at', 'offs', 'is_activated', 'created_at', 'updated_at'];


    protected $casts = [
        "offs" => "json",
        "is_activated" => "boolean"
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(config('filament-accounts.model'));
    }
}
