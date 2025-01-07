<?php

namespace App\Models\Inventory_Module;

use Illuminate\Database\Eloquent\Model;

class MaterialReceipt extends Model
{
    protected $fillable = [
        'material_id',
        'customer_id', // Ensure this is included to allow mass assignment
        'quantity',
        'receipt_date',
        'cost_per_unit', 
        'entity_name',
        'notes',
        'receipt_type',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'cost_per_unit' => 'decimal:2',
        'receipt_date' => 'date',
    ];

    /**
     * Define the relationship to the Material model.
     */
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'material_id');
    }

    /**
     * Define the relationship to the Customer model.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
