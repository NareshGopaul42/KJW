<?php

namespace App\Models\Inventory_Module;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory_Module\Employee; 
use App\Models\Inventory_Module\Customer; 

class MaterialAssignment extends Model
{
    protected $table = 'material_assignments';
    protected $primaryKey = 'assignment_id';

    protected $fillable = [
        'material_id',
        'employee_id',
        'customer_id',
        'weight_assigned',
        'weight_returned',
        'loss',
        'task_description',
        'workshop',
        'date_assigned',
        'date_due',
        'date_returned',
        'status',
        'notes'
    ];

    protected $casts = [
        'weight_assigned' => 'decimal:3',
        'weight_returned' => 'decimal:3',
        'loss' => 'decimal:3',
        'date_assigned' => 'date',
        'date_due' => 'date',
        'date_returned' => 'date'
    ];

    // Relationships
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'material_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function updateStock($quantity, $operation = 'add')
    {
        if ($operation === 'add') {
            $this->current_stock += $quantity;
        } elseif ($operation === 'subtract') {
            if ($this->current_stock < $quantity) {
                throw new \Exception("Insufficient stock for material: {$this->name}");
            }
            $this->current_stock -= $quantity;
        }
        $this->save();
    }



    // Calculate loss when material is returned
    public function calculateLoss()
    {
        if ($this->weight_returned !== null) {
            $this->loss = $this->weight_assigned - $this->weight_returned;
            $this->save();
        }
        return $this->loss;
    }

    // Update status
    public function markReturned($weightReturned)
    {
        $this->update([
            'weight_returned' => $weightReturned,
            'date_returned' => now(),
            'status' => 'Returned',
        ]);

        $this->calculateLoss();
    }

}