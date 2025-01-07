<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inventory_Module\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of active employees.
     */
    public function index()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('inventory_module.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('inventory_module.employees.create');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:employees',
            'proper_name' => 'required',
            'email' => 'nullable|email|unique:employees',
            'phone' => 'nullable',
            'workshop' => 'nullable',
            'role' => 'required',
            'access_level' => 'required',
            'department' => 'nullable',
        ]);

        Employee::create($validatedData);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        return view('inventory_module.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        return view('inventory_module.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:employees,username,' . $employee->employee_id . ',employee_id',
            'proper_name' => 'required',
            'email' => 'nullable|email|unique:employees,email,' . $employee->employee_id . ',employee_id',
            'phone' => 'nullable',
            'workshop' => 'nullable',
            'role' => 'required',
            'access_level' => 'required',
            'department' => 'nullable',
        ]);

        $employee->update($validatedData);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Get active employees for dropdown.
     */
    public function getActiveEmployees()
    {
        $employees = Employee::where('status', 'active')
            ->select('employee_id', 'proper_name', 'role')
            ->get();
            
        return response()->json($employees);
    }

    /**
     * Toggle employee status (active/inactive)
     */
    public function toggleStatus(Employee $employee)
    {
        $employee->status = $employee->status === 'active' ? 'inactive' : 'active';
        $employee->save();

        return response()->json([
            'status' => $employee->status,
            'message' => 'Employee status updated successfully'
        ]);
    }
}