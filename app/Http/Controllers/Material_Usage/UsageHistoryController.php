<?php

namespace App\Http\Controllers\Material_Usage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsageHistoryController extends Controller
{
    public function index()
    {
        $trackings = DB::table('material_usage')
            ->join('employees', 'material_usage.employee_id', '=', 'employees.employee_id')
            ->join('materials', 'material_usage.material_id', '=', 'materials.material_id')
            ->join('job_batches', 'material_usage.batch_number', '=', 'job_batches.batch_number')
            ->select(
                'material_usage.*',
                'employees.proper_name as employee_name',
                'materials.name as material_name',
                'job_batches.status as batch_status'
            )
            ->orderBy('material_usage.created_at', 'desc')
            ->paginate(15);

        return view('material_usage.usage_history', compact('trackings'));
    }
}