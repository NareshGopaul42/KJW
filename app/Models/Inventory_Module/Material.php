<?php

namespace App\Models\Inventory_Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'materials';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'material_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sub_category',
        'current_stock',
        'minimum_threshold',
        'unit',
        'status',
        'cost_per_dwt',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'current_stock' => 'decimal:3',
        'minimum_threshold' => 'decimal:3',
        'cost_per_dwt' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'In Stock',
        'unit' => 'dwt',
    ];

    /**
     * Get the validation rules for material creation/update.
     *
     * @return array
     */
    public static function validationRules()
    {
        return [
            'name' => 'required|string|max:100',
            'sub_category' => 'required|string|max:50',
            'current_stock' => 'required|numeric|min:0',
            'minimum_threshold' => 'required|numeric|min:0',
            'unit' => 'string|max:10',
            'cost_per_dwt' => 'nullable|numeric|min:0',
            'status' => 'string|max:20',
        ];
    }

    /**
     * Check if the material stock is below minimum threshold.
     *
     * @return bool
     */
    public function isLowStock()
    {
        return $this->current_stock <= $this->minimum_threshold;
    }

    /**
     * Update the material's stock.
     *
     * @param float $quantity
     * @param string $operation ('add' or 'subtract')
     * @return void
     * @throws \Exception
    */
    public function updateStock(float $quantity, string $operation = 'add'): void
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


}