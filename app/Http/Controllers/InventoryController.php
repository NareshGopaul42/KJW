<?php

namespace App\Http\Controllers;

use App\Models\Inventory_Module\Material;
use App\Models\Inventory_Module\MaterialReceipt;
use App\Models\Inventory_Module\Employee; 
use App\Models\Inventory_Module\Customer; 
use App\Models\Inventory_Module\MaterialAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
{
    $materials = Material::all();
    return view('inventory', compact('materials'));
}

    public function create()
    {
        return view('components.inventory_module.modals.add-material');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'sub_category' => 'required|string|max:50',
            'current_stock' => 'required|numeric|min:0',
            'minimum_threshold' => 'required|numeric|min:0',
            'unit' => 'required|string|max:10',
            'cost_per_dwt' => 'nullable|numeric|min:0',
        ]);

        $material = new Material();
        $material->name = $validatedData['name'];
        $material->sub_category = $validatedData['sub_category'];
        $material->current_stock = $validatedData['current_stock'];
        $material->minimum_threshold = $validatedData['minimum_threshold'];
        $material->unit = $validatedData['unit'];
        $material->cost_per_dwt = $validatedData['cost_per_dwt'];
        $material->save();

        return redirect()->route('inventory.index')->with('success', 'Material added successfully.');
    }

    public function createReceipt()
    {
        $materials = Material::select('name', 'sub_category')
            ->where('status', 'In Stock')
            ->get();
    
        $materialTypes = $materials->pluck('name')->unique();
        $subCategories = $materials->groupBy('name')->map->pluck('sub_category')->map->unique();
    
        // Fetch active customers
        $customers = Customer::select('customer_id', 'first_name', 'last_name')
            ->where('status', 'Active')
            ->get();
    
        return view('components.inventory_module.modals.record-receipt', 
            compact('materialTypes', 'subCategories', 'customers'));
    }

    public function storeReceipt(Request $request)
{
    $validatedData = $request->validate([
        'material_type' => 'required|string',
        'sub_category' => 'required|string',
        'quantity' => 'required|numeric|min:0',
        'receipt_date' => 'required|date',
        'cost_per_dwt' => 'required|numeric|min:0',
        'notes' => 'nullable|string|max:500',
        'receipt_type' => 'required|in:custom_order,sale_to_store,purchase',
        'customer_first_name' => 'required_if:receipt_type,custom_order,sale_to_store',
        'customer_last_name' => 'required_if:receipt_type,custom_order,sale_to_store',
        'customer_phone' => 'nullable|string|max:15',
        'customer_email' => 'nullable|email|max:100',
        'customer_address' => 'nullable|string',
    ]);

    try {
        DB::transaction(function () use ($validatedData) {
            // Find the material
            $material = Material::where('name', $validatedData['material_type'])
                ->where('sub_category', $validatedData['sub_category'])
                ->firstOrFail();

            // Handle customer logic
            $customer = null;
            if (in_array($validatedData['receipt_type'], ['custom_order', 'sale_to_store'])) {
                // Search for an existing customer
                $customer = Customer::where('first_name', $validatedData['customer_first_name'])
                    ->where('last_name', $validatedData['customer_last_name'])
                    ->when(!empty($validatedData['customer_phone']), function ($query) use ($validatedData) {
                        return $query->where('phone', $validatedData['customer_phone']);
                    })
                    ->first();

                if (!$customer) {
                    // Create a new customer
                    $customer = Customer::create([
                        'first_name' => $validatedData['customer_first_name'],
                        'last_name' => $validatedData['customer_last_name'],
                        'phone' => $validatedData['customer_phone'],
                        'email' => $validatedData['customer_email'],
                        'address' => $validatedData['customer_address'],
                        'status' => 'Active',
                    ]);
                    \Log::info("New customer created with ID: {$customer->customer_id}");
                } else {
                    // Update existing customer if necessary
                    $updated = $customer->update([
                        'email' => $validatedData['customer_email'] ?? $customer->email,
                        'address' => $validatedData['customer_address'] ?? $customer->address,
                    ]);
                    if ($updated) {
                        \Log::info("Customer with ID {$customer->customer_id} updated.");
                    } else {
                        \Log::info("No updates required for customer with ID {$customer->customer_id}.");
                    }
                }
            }

            // Determine the entity name for the receipt
            $entityName = $customer ? "{$customer->first_name} {$customer->last_name}" : null;

            // Create the material receipt
            \Log::info("MaterialReceipt being created with customer_id: " . ($customer ? $customer->customer_id : 'NULL'));
            MaterialReceipt::create([
                'material_id' => $material->material_id,
                'customer_id' => $customer ? $customer->customer_id : null,
                'quantity' => $validatedData['quantity'],
                'receipt_date' => $validatedData['receipt_date'],
                'cost_per_unit' => $validatedData['cost_per_dwt'],
                'entity_name' => $entityName,
                'notes' => $validatedData['notes'],
                'receipt_type' => $validatedData['receipt_type'],
            ]);

            // Update material stock
            $material->updateStock($validatedData['quantity'], 'add');
        });

        return redirect()->route('inventory.index')
            ->with('success', 'Material receipt recorded successfully.');
    } catch (\Exception $e) {
        \Log::error('Receipt creation failed: ' . $e->getMessage());
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to record receipt: ' . $e->getMessage());
    }
}




       public function createAssignment()
    {
        $materials = Material::select('material_id', 'name', 'current_stock', 'sub_category')
            ->where('status', 'In Stock')
            ->where('current_stock', '>', 0)
            ->get();

        $materialTypes = $materials->pluck('name')->unique();
        $subCategories = $materials->groupBy('name')
                                 ->map->pluck('sub_category')
                                 ->map->unique();

        $employees = Employee::select('employee_id', 'proper_name', 'role')
            ->where('status', 'active')
            ->orderBy('proper_name')
            ->get();

        $customers = Customer::select(
            'customer_id',
            DB::raw("CONCAT(first_name, ' ', last_name) as full_name")
        )
            ->where('status', 'Active')
            ->get();

        return view('components.inventory_module.modals.record-usage', 
            compact('materials', 'materialTypes', 'subCategories', 'employees', 'customers'));
    }

    public function storeAssignment(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
            'customer' => 'nullable|string|max:255',
            'material_type' => 'required|string',
            'sub_category' => 'required|string',
            'weight_assigned' => 'required|numeric|min:0.001',
            'purpose' => 'required|string|in:new_piece,repair,modification,other',
            'other_purpose' => 'nullable|required_if:purpose,other|string|max:255',
            'date_due' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $material = Material::where('name', $validatedData['material_type'])
                    ->where('sub_category', $validatedData['sub_category'])
                    ->firstOrFail();

                if ($material->current_stock < $validatedData['weight_assigned']) {
                    throw new \Exception('Insufficient stock for the selected material.');
                }

                $material->updateStock($validatedData['weight_assigned'], 'subtract');

                MaterialAssignment::create([
                    'material_id' => $material->material_id,
                    'employee_id' => $validatedData['employee_id'],
                    'customer_id' => $validatedData['customer'] ?? null,
                    'weight_assigned' => $validatedData['weight_assigned'],
                    'task_description' => $validatedData['purpose'] === 'other' 
                        ? $validatedData['other_purpose'] 
                        : $validatedData['purpose'],
                    'workshop' => $validatedData['notes'],
                    'date_assigned' => now(),
                    'date_due' => $validatedData['date_due'],
                    'status' => 'Assigned',
                ]);
            });

            return redirect()->route('inventory.index')
                ->with('success', 'Material usage recorded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}