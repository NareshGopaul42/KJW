<?php

namespace App\Http\Controllers\Material_Usage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LossCalculationController extends Controller
{
    public function index()
    {
        $employees = DB::table('employees')->get();
        $materials = DB::table('materials')->get();
        $jobs = DB::table('jobs')->get(['id', 'queue']);

        return view('material_usage.loss_calculation', compact('employees', 'materials', 'jobs'));
    }

    public function store(Request $request)
    {
        Log::info('Incoming form data:', $request->all());

        try {
            $validated = $request->validate([
                'employee_id' => 'required|integer',
                'material_id' => 'required|integer',
                'job_id' => 'required|integer',
                'init_weight' => 'required|numeric|min:0',
                'final_weight' => 'required|numeric|min:0',
                'loss_amt' => 'required|numeric|min:0',
                'loss_percent' => 'required|numeric|min:0'
            ]);

            // Insert data without timestamps
            $result = DB::table('losses')->insert([
                'employee_id' => (int)$validated['employee_id'],
                'material_id' => (int)$validated['material_id'],
                'job_id' => (int)$validated['job_id'],
                'init_weight' => (int)($validated['init_weight'] * 100),
                'final_weight' => (int)($validated['final_weight'] * 100),
                'loss_amt' => (int)($validated['loss_amt'] * 100),
                'loss_percent' => (float)$validated['loss_percent']
            ]);

            if ($result) {
                return redirect()->route('material_usage.loss_calculation')
                    ->with('success', 'Loss calculation recorded successfully');
            }

            throw new \Exception('Failed to insert record');

        } catch (\Exception $e) {
            Log::error('Loss calculation error:', [
                'message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error saving calculation: ' . $e->getMessage()]);
        }
    }
}