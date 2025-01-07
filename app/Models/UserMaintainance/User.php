<?php

namespace App\Models\User_Maintenance;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Inventory_Module\Employee;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationship with Employee
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    // Check if user is active
    public function isActive()
    {
        return $this->status === 'active';
    }

    // Update last login timestamp
    public function updateLastLogin()
    {
        $this->last_login = now();
        $this->save();
    }

    // Get user's full name
    public function getFullNameAttribute()
    {
        return $this->name;
    }
}