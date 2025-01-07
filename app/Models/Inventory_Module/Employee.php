<?php

namespace App\Models\Inventory_Module;

use Illuminate\Database\Eloquent\Model;
use App\Models\User_Maintenance\User;  // Update this namespace based on your User model location

class Employee extends Model
{
    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'username',
        'proper_name',
        'email',
        'phone',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'workshop',
        'language',
        'role',
        'access_level',
        'status',
        'is_locked',
        'last_activity',
        'password_expiry_date',
        'password_never_expires',
        'password_change_date',
        'default_branch',
        'department',
        'valid_workshops',
        'valid_branches',
        'user_id'
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'password_never_expires' => 'boolean',
        'last_activity' => 'datetime',
        'password_expiry_date' => 'datetime',
        'password_change_date' => 'datetime',
        'valid_workshops' => 'array',
        'valid_branches' => 'array'
    ];

    // Relationship with User model - Update the namespace based on your User model location
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with MaterialAssignment
    public function materialAssignments()
    {
        return $this->hasMany(MaterialAssignment::class, 'employee_id', 'employee_id');
    }

    // Rest of the methods remain the same...
}