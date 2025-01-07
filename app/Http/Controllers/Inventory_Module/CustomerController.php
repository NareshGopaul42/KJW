<?php

namespace App\Http\Controllers\Inventory_Module;

use App\Http\Controllers\Controller;
use App\Models\Inventory_Module\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        $customers = Customer::orderBy('first_name')
                           ->orderBy('last_name')
                           ->paginate(10);
        return view('inventory_module.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('inventory_module.customers.create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string',
            'status' => 'required|string|in:Active,Inactive',
            'notes' => 'nullable|string',
            'preferred_contact_method' => 'nullable|string|in:Phone,Email,Both'
        ]);

        try {
            Customer::create($validatedData);
            return redirect()->route('customers.index')
                           ->with('success', 'Customer created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Error creating customer: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer)
    {
        return view('inventory_module.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        return view('inventory_module.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string',
            'status' => 'required|string|in:Active,Inactive',
            'notes' => 'nullable|string',
            'preferred_contact_method' => 'nullable|string|in:Phone,Email,Both'
        ]);

        try {
            $customer->update($validatedData);
            return redirect()->route('customers.index')
                           ->with('success', 'Customer updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Error updating customer: ' . $e->getMessage());
        }
    }

    /**
     * Search for customers.
     */
    public function search(Request $request)
    {
        $search = $request->get('search');
        $customers = Customer::search($search)
                           ->orderBy('first_name')
                           ->orderBy('last_name')
                           ->paginate(10);
                           
        return response()->json($customers);
    }

    /**
     * Get active customers for dropdown.
     * 
     */
    public function getActiveCustomers()
    {
        try {
            $customers = Customer::active()
                            ->select('customer_id', 'first_name', 'last_name', 'phone')
                            ->orderBy('first_name')
                            ->orderBy('last_name')
                            ->get()
                            ->map(function ($customer) {
                                return [
                                    'id' => $customer->customer_id,
                                    'name' => $customer->first_name . ' ' . $customer->last_name,
                                    'phone' => $customer->phone
                                ];
                            });
            
            \Log::info('Active customers retrieved:', ['count' => $customers->count()]);
            return response()->json($customers);
        } catch (\Exception $e) {
            \Log::error('Error retrieving active customers: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve customers'], 500);
        }
    }

     



     

    // To get the customer materials
    public function getCustomerMaterials(Customer $customer, Request $request)
{
    try {
        \Log::info('Getting materials for customer', [
            'customer_id' => $customer->customer_id,
            'job_type' => $request->type
        ]);

        $materials = DB::table('material_receipts as mr')
            ->join('materials as m', 'm.material_id', '=', 'mr.material_id')
            ->select(
                'mr.id',
                'mr.material_id', // Added material_id
                'mr.receipt_type',
                'm.name as material_type',
                'm.sub_category',
                DB::raw('SUM(mr.quantity) as total_weight'),
                'mr.customer_id'
            )
            ->where('mr.customer_id', $customer->customer_id)
            ->where('mr.receipt_type', 'custom_order')
            ->groupBy('mr.id', 'mr.material_id', 'mr.receipt_type', 'm.name', 'm.sub_category', 'mr.customer_id')
            ->get();

        \Log::info('Query result:', [
            'materials' => $materials
        ]);

        return response()->json([
            'materials' => [
                'Illuminate\\Support\\Collection' => $materials
            ]
        ]);

    } catch (\Exception $e) {
        \Log::error('Error fetching customer materials:', [
            'error' => $e->getMessage(),
            'stack' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    
   
    /**
     * Toggle customer status.
     */
    public function toggleStatus(Customer $customer)
    {
        try {
            $customer->status = $customer->status === 'Active' ? 'Inactive' : 'Active';
            $customer->save();

            return response()->json([
                'status' => $customer->status,
                'message' => 'Customer status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error updating customer status: ' . $e->getMessage()
            ], 500);
        }
    }
}