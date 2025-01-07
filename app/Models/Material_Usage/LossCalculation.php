<?php

namespace App\Models\Material_Usage;

use Illuminate\Database\Eloquent\Model;

class LossCalculation extends Model
{
    protected $table = 'losses';

    protected $fillable = [
        'employee_id',
        'material_id',
        'job_id',
        'init_weight',
        'final_weigth',
        'loss_amt',
        'loss_percent'
    ];

}