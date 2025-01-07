<?php

namespace App\Models\Inventory_Module;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    public $incrementing = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'status',
        'notes',
        'preferred_contact_method',
        'last_visit'
    ];

    protected $casts = [
        'last_visit' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Get full name accessor
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Relationship with MaterialAssignment
    public function materialAssignments()
    {
        return $this->hasMany(MaterialAssignment::class, 'customer_id', 'customer_id');
    }

    // Scope for active customers
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    // Scope for searching customers
    public function scopeSearch($query, $search)
    {
        return $query->where(function($query) use ($search) {
            $query->where('first_name', 'ILIKE', "%{$search}%")
                  ->orWhere('last_name', 'ILIKE', "%{$search}%")
                  ->orWhere('phone', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%");
        });
    }

    // Update last visit timestamp
    public function updateLastVisit()
    {
        $this->last_visit = now();
        $this->save();
    }
}