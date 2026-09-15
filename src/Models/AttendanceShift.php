<?php

namespace TomatoPHP\FilamentEmployees\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TomatoPHP\FilamentEmployees\Database\Factories\AttendanceShiftFactory;

/**
 * @property int $id
 * @property int $department_id
 * @property string $name
 * @property string $type
 * @property string $start_at
 * @property string $end_at
 * @property mixed $offs
 * @property bool $is_activated
 * @property string $created_at
 * @property string $updated_at
 * @property Department $department
 * @property Employee[] $employees
 */
class AttendanceShift extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['department', 'name', 'type', 'start_at', 'end_at', 'offs', 'is_activated', 'created_at', 'updated_at'];

    protected $casts = [
        'offs' => 'json',
        'is_activated' => 'boolean',
    ];

    /**
     * @return HasMany
     */
    public function accounts()
    {
        return $this->hasMany(config('filament-accounts.model'));
    }

    protected static function newFactory(): AttendanceShiftFactory
    {
        return AttendanceShiftFactory::new();
    }
}
