<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WeightRecordingController extends Controller
{
    public function index()
    {
        try {
            // Get employees from the database
            $employees = DB::table('employees')
                ->select('username', 'proper_name')
                ->orderBy('proper_name')
                ->get();

            // Get materials from the database
            $materials = DB::table('materials')
                ->select('material_id')
                ->orderBy('material_id')
                ->get();

            // Get jobs from the database
            $jobs = DB::table('jobs')
                ->select('id')
                ->orderBy('id')
                ->get();

            return view('material_usage.weight_recording', [
                'employees' => $employees,
                'materials' => $materials,
                'jobs' => $jobs
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching data:', [
                'error' => $e->getMessage()
            ]);
            
            return view('material_usage.weight_recording', [
                'employees' => [],
                'materials' => [],
                'jobs' => [],
                'error' => 'Unable to fetch data: ' . $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Incoming request data:', $request->all());

            // Validate the request
            $validated = $request->validate([
                'employee' => 'required|string',
                'material_id' => 'required|integer',
                'task_id' => 'required|integer',
                'stage' => 'required|string',
                'current_weight' => 'required|numeric|min:0',
                'notes' => 'nullable|string',
                'date_time' => 'required|date'
            ]);

            // Insert into weight_recording table
            DB::table('weight_recording')->insert([
                'task_id' => (int)$request->task_id,
                'created_at' => now(),
                'Stage' => $request->stage,
                'current_weight' => (int)$request->current_weight,
                'notes' => $request->notes,
                'date' => $request->date_time,
                'material_id' => (int)$request->material_id,
                'employee' => $request->employee
            ]);

            return redirect()->route('material_usage.weight_recording')
                ->with('success', 'Weight recorded successfully');

        } catch (\Exception $e) {
            Log::error('Error storing weight recording:', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to record weight: ' . $e->getMessage());
        }
    }
}