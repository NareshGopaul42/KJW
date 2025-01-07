<?php

namespace App\Models\Material_Usage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class material_tracking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'material_tracking';

    protected $primaryKey = 'id';

    protected $fillable = [
        'material_id',
        'batch_number',
        'customer',
        'amount_received',
        'date_received',
        'unit_of_measure',
        'storage',
        'assigned_to',
        'status'
    ];

    protected $casts = [
        'date_received' => 'datetime',
        'amount_received' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $attributes = [
        'status' => 'pending',
        'unit_of_measure' => 'dwt'
    ];

    // Validation rules
    public static $rules = [
        'material_id' => 'required|string|max:255',
        'batch_number' => 'required|string|max:255',
        'customer' => 'required|string|max:255',
        'amount_received' => 'required|numeric|min:0',
        'date_received' => 'required|date',
        'unit_of_measure' => 'required|string|max:50',
        'storage' => 'required|string|max:255',
        'assigned_to' => 'required|string|max:255',
        'status' => 'required|in:pending,in_progress,completed'
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';

    // Get available statuses
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED => 'Completed'
        ];
    }

    // Scope to filter by status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope to filter by date range
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date_received', [$startDate, $endDate]);
    }

    // Get materials by customer
    public function scopeByCustomer($query, $customer)
    {
        return $query->where('customer', $customer);
    }

    // Get materials by storage location
    public function scopeByStorage($query, $storage)
    {
        return $query->where('storage', $storage);
    }

    // Get materials assigned to specific employee
    public function scopeAssignedTo($query, $employee)
    {
        return $query->where('assigned_to', $employee);
    }

    // Check if material is completed
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    // Check if material is in progress
    public function isInProgress()
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    // Check if material is pending
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    // Update status
    public function updateStatus($status)
    {
        if (in_array($status, array_keys(self::getStatuses()))) {
            $this->update(['status' => $status]);
            return true;
        }
        return false;
    }
}