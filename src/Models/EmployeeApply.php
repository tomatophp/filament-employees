<?php

namespace TomatoPHP\FilamentEmployees\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TomatoPHP\FilamentEmployees\Database\Factories\EmployeeApplyFactory;

/**
 * @property int $id
 * @property int $hr_approved_by
 * @property int $tech_approved_by
 * @property int $is_approved_by
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $birthday
 * @property string $id_type
 * @property string $id_number
 * @property string $education_type
 * @property string $university
 * @property string $college
 * @property string $department
 * @property string $position
 * @property string $hr_cover_letter
 * @property bool $has_insurance
 * @property string $insurance_number
 * @property float $explicated_salary
 * @property string $start_at
 * @property string $status
 * @property string $hr_notes
 * @property string $tech_notes
 * @property bool $is_activated
 * @property bool $ready_for_interview
 * @property bool $hr_approved
 * @property bool $tech_approved
 * @property bool $is_approved
 * @property string $created_at
 * @property string $updated_at
 * @property User $hrApproved
 * @property User $approvedBy
 * @property User $techApproved
 */
class EmployeeApply extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['hr_approved_by', 'tech_approved_by', 'is_approved_by', 'first_name', 'last_name', 'address', 'phone', 'email', 'birthday', 'id_type', 'id_number', 'education_type', 'university', 'college', 'department', 'position', 'hr_cover_letter', 'has_insurance', 'insurance_number', 'explicated_salary', 'start_at', 'status', 'hr_notes', 'tech_notes', 'is_activated', 'ready_for_interview', 'hr_approved', 'tech_approved', 'is_approved', 'created_at', 'updated_at'];

    protected $casts = [
        'is_activated' => 'boolean',
        'is_approved' => 'boolean',
        'ready_for_interview' => 'boolean',
        'hr_approved' => 'boolean',
        'tech_approved' => 'boolean',
        'has_insurance' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function hrApproved()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'hr_approved_by');
    }

    /**
     * @return BelongsTo
     */
    public function approvedBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'is_approved_by');
    }

    /**
     * @return BelongsTo
     */
    public function techApproved()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'tech_approved_by');
    }

    protected static function newFactory(): EmployeeApplyFactory
    {
        return EmployeeApplyFactory::new();
    }
}
