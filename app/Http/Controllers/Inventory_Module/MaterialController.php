<?php

namespace App\Http\Controllers\Inventory_Module;

use App\Http\Controllers\Controller;
use App\Models\Inventory_Module\Material;
use App\Models\Inventory_Module\MaterialAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
{
   
   /**
     * Display a listing of materials
     */
    public function index()
    {
        $materials = Material::select('materials.*')
            ->selectRaw('
                COALESCE(SUM(CASE 
                    WHEN mr.receipt_type IN (\'purchase\', \'sale_to_store\') 
                    THEN mr.quantity 
                    ELSE 0 
                END), 0) as business_stock
            ')
            ->selectRaw('
                COALESCE(SUM(CASE 
                    WHEN mr.receipt_type = \'custom_order\' 
                    THEN mr.quantity 
                    ELSE 0 
                END), 0) as customer_stock
            ')
            ->leftJoin('material_receipts as mr', 'materials.material_id', '=', 'mr.material_id')
            ->groupBy('materials.material_id')
            ->get();

        return view('inventory', compact('materials'));
    }

    /**
     * Show the form for creating a new material
     */
    public function create()
    {
        return view('components.inventory_module.modals.add-material');
    }

    /**
     * Store a newly created material
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(Material::validationRules());

        try {
            Material::create($validatedData);
            return redirect()->route('materials.index')
                           ->with('success', 'Material created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating material:', [
                'error' => $e->getMessage(),
                'data' => $validatedData
            ]);
            return back()->withInput()
                        ->with('error', 'Error creating material: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified material
     */
    public function show(Material $material)
    {
        // Load related assignments and receipts
        $material->load([
            'assignments' => function($query) {
                $query->orderBy('date_assigned', 'desc')
                      ->take(10);
            },
            'receipts' => function($query) {
                $query->orderBy('receipt_date', 'desc')
                      ->take(10);
            }
        ]);

        return view('inventory', compact('materials'));
    }

    //Material History

     /**
     * Display all material history (General History Page)
     */
    public function allHistory()
    {
        $history = DB::table('material_receipts')
            ->select(
                DB::raw("TO_CHAR(material_receipts.created_at, 'YYYY-MM-DD HH24:MI:SS') AS receipt_date"),
                'material_receipts.receipt_type',
                'material_receipts.quantity',
                'material_receipts.notes',
                'materials.name as material_name',
                'materials.sub_category',
                'materials.unit',
                'material_receipts.entity_name',
                DB::raw("CONCAT(customers.first_name, ' ', customers.last_name) as customer_name")
            )
            ->join('materials', 'materials.material_id', '=', 'material_receipts.material_id')
            ->leftJoin('customers', 'customers.customer_id', '=', 'material_receipts.customer_id')
            ->orderBy('material_receipts.created_at', 'desc')
            ->get();
    
        return view('components.inventory_module.modals.material-history', compact('history'));
    }


    public function allReceipts()
{
    $history = DB::table('material_receipts')
        ->select(
            'material_receipts.id',
            DB::raw("TO_CHAR(material_receipts.created_at, 'YYYY-MM-DD HH24:MI:SS') AS receipt_date"),
            'material_receipts.receipt_type',
            'material_receipts.quantity',
            'material_receipts.notes',
            'materials.name as material_name',
            'materials.sub_category',
            'materials.unit',
            'material_receipts.entity_name',
            DB::raw("CONCAT(customers.first_name, ' ', customers.last_name) as customer_name")
        )
        ->join('materials', 'materials.material_id', '=', 'material_receipts.material_id')
        ->leftJoin('customers', 'customers.customer_id', '=', 'material_receipts.customer_id')
        ->orderBy('material_receipts.created_at', 'desc')
        ->get();

    if (request()->ajax()) {
        return response()->json(['history' => $history]);
    }

    return view('components.inventory_module.modals.edit-material-receipts', compact('history'));
}

    public function editReceipt($id)
    {
        // Get the specific receipt with related material info
        $receipt = DB::table('material_receipts')
            ->select(
                'material_receipts.id',
                'material_receipts.receipt_type',
                'material_receipts.quantity',
                'material_receipts.receipt_date',
                'material_receipts.cost_per_unit',
                'material_receipts.entity_name',
                'material_receipts.notes',
                'materials.name as material_type',
                'materials.sub_category',
                DB::raw('COALESCE(customers.first_name, \'\') as customer_first_name'),
                DB::raw('COALESCE(customers.last_name, \'\') as customer_last_name'),
                DB::raw('COALESCE(customers.email, \'\') as customer_email'),
                DB::raw('COALESCE(customers.phone, \'\') as customer_phone'),
                DB::raw('COALESCE(customers.address, \'\') as customer_address')
            )
            ->join('materials', 'materials.material_id', '=', 'material_receipts.material_id')
            ->leftJoin('customers', 'customers.customer_id', '=', 'material_receipts.customer_id')
            ->where('material_receipts.id', $id)
            ->first();

        if (!$receipt) {
            return redirect()->back()->with('error', 'Receipt not found');
        }

        // Get unique material names
        $materialNames = DB::table('materials')
            ->select('name')
            ->distinct()
            ->pluck('name');

        // Get unique sub_categories (purities)
        $subCategories = DB::table('materials')
            ->select('sub_category')
            ->distinct()
            ->pluck('sub_category');

            return view('components.inventory_module.modals.edit-receipt', compact('receipt', 'materialNames', 'subCategories'));
    }

    
    public function updateReceipt(Request $request, $id)
{
    try {
        $validatedData = $request->validate([
            'receipt_type' => 'required|in:custom_order,sale_to_store,purchase',
            'material_type' => 'required|exists:materials,name',
            'sub_category' => 'required|exists:materials,sub_category',
            'quantity' => 'required|numeric|min:0',
            'receipt_date' => 'required|date',
            'cost_per_unit' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();

        // Get material_id based on material_type and sub_category
        $materialId = DB::table('materials')
            ->where('name', $request->material_type)
            ->where('sub_category', $request->sub_category)
            ->value('material_id');

        // Update only the material_receipts table
        DB::table('material_receipts')
            ->where('id', $id)
            ->update([
                'receipt_type' => $validatedData['receipt_type'],
                'material_id' => $materialId,
                'quantity' => $validatedData['quantity'],
                'receipt_date' => $validatedData['receipt_date'],
                'cost_per_unit' => $validatedData['cost_per_unit'],
                'notes' => $validatedData['notes'],
                'updated_at' => now()
            ]);

        DB::commit();

        return redirect()->route('materials.receipts')
            ->with('success', 'Receipt updated successfully');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error updating receipt:', [
            'error' => $e->getMessage(),
            'receipt_id' => $id
        ]);
        return redirect()->back()
            ->with('error', 'Error updating receipt: ' . $e->getMessage())
            ->withInput();
    }
}

    public function deleteReceipt($id)
    {
        try {
            // Find and delete the receipt
            DB::table('material_receipts')->where('id', $id)->delete();
            
            return redirect()->back()->with('success', 'Receipt deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting receipt:', [
                'error' => $e->getMessage(),
                'receipt_id' => $id
            ]);
            return redirect()->back()->with('error', 'Error deleting receipt');
        }
    }

    

    /**
     * Get materials for internal production
     */
    public function getInternalMaterials()
    {
        try {
            Log::info('Fetching materials for internal production');

            // Enable query logging
            DB::enableQueryLog();

            $materials = DB::table('material_receipts as mr')
                ->join('materials as m', 'm.material_id', '=', 'mr.material_id')
                ->select(
                    'mr.material_id',
                    'm.name as material_type',
                    'm.sub_category',
                    DB::raw('SUM(mr.quantity) as total_weight')
                )
                ->whereIn('mr.receipt_type', ['sale_to_store', 'purchase'])
                ->where('m.status', 'In Stock')
                ->groupBy('mr.material_id', 'm.name', 'm.sub_category')
                ->having('total_weight', '>', 0)
                ->get();

            // Log the executed query
            Log::info('Internal materials query:', [
                'query' => DB::getQueryLog(),
                'results' => $materials
            ]);

            return response()->json(['materials' => $materials]);

        } catch (\Exception $e) {
            Log::error('Error fetching internal materials:', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Record material assignment
     */
    public function recordAssignment(Request $request)
    {
        $validatedData = $request->validate([
            'material_id' => 'required|exists:materials,material_id',
            'employee_id' => 'required|exists:employees,employee_id',
            'customer_id' => 'required_unless:workshop,internal|exists:customers,customer_id',
            'weight_assigned' => 'required|numeric|min:0',
            'task_description' => 'required|string',
            'workshop' => 'required|string',
            'date_assigned' => 'required|date',
            'date_due' => 'required|date|after_or_equal:date_assigned',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Check if there's enough stock
            $material = Material::findOrFail($validatedData['material_id']);
            if ($material->current_stock < $validatedData['weight_assigned']) {
                throw new \Exception("Insufficient stock for material: {$material->name}");
            }

            // Create assignment record
            $assignment = MaterialAssignment::create($validatedData + ['status' => 'Assigned']);

            // Update material stock
            $material->updateStock($validatedData['weight_assigned'], 'subtract');

            DB::commit();

            return redirect()->route('materials.index')
                           ->with('success', 'Material assigned successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error recording material assignment:', [
                'error' => $e->getMessage(),
                'data' => $validatedData
            ]);
            return back()->withInput()
                        ->with('error', 'Error recording material assignment: ' . $e->getMessage());
        }
    }

    /**
     * Get current inventory levels
     */
    public function getInventoryLevels()
    {
        try {
            $materials = Material::all()->map(function ($material) {
                return [
                    'material_id' => $material->material_id,
                    'name' => $material->name,
                    'sub_category' => $material->sub_category,
                    'current_stock' => $material->current_stock,
                    'minimum_threshold' => $material->minimum_threshold,
                    'status' => $material->status,
                    'is_low_stock' => $material->isLowStock()
                ];
            });

            return response()->json(['inventory' => $materials]);

        } catch (\Exception $e) {
            Log::error('Error fetching inventory levels:', [
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Search materials
     */
    public function search(Request $request)
    {
        $search = $request->get('search');
        
        $materials = Material::where('name', 'like', "%{$search}%")
                           ->orWhere('sub_category', 'like', "%{$search}%")
                           ->orderBy('name')
                           ->orderBy('sub_category')
                           ->paginate(10);

        if ($request->ajax()) {
            return response()->json($materials);
        }

        return view('inventory_module.materials.index', compact('materials'));
    }
}