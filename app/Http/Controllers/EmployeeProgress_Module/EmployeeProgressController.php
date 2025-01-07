<?php

namespace App\Http\Controllers\EmployeeProgress_Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeProgressController extends Controller
{
    public function index()
    {
        try {
            // Simple query to get all employees
            $employees = DB::table('employees')
                ->select('*')
                ->get();

            // Debug the query output
            // dd($employees);  // Uncomment this line to debug

            return view('employee_progress_main', ['employees' => $employees]);
            
        } catch (\Exception $e) {
            // Log any errors
            \Log::error('Error fetching employees: ' . $e->getMessage());
            return view('employee_progress_main', ['employees' => collect([])]);
        }
    }
}