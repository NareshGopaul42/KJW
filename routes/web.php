<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Inventory_Module\CustomerController;
use App\Http\Controllers\Inventory_Module\MaterialController;

use App\Http\Controllers\Material_Usage\MaterialTrackingController;
use App\Http\Controllers\WeightRecordingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Material_Usage\LossCalculationController;
use App\Http\Controllers\Material_Usage\UsageHistoryController;
use App\Http\Controllers\EmployeeProgress_Module\EmployeeProgressController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Basic Pages
Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
Route::get('/home', function () {
    return view('home');
})->name('home');

// Inventory Management Routes
// Material History and Receipts
Route::prefix('inventory')->group(function () {

    // Material History
    Route::get('/materials/history/all', [MaterialController::class, 'allHistory']);
    Route::get('/materials/history', [MaterialController::class, 'allHistory'])->name('materials.history');
    Route::get('/materials/history/filter', [MaterialController::class, 'filterHistory']);

    // Edit Receipt Records - Updated grouping
    Route::prefix('materials/receipts')->group(function () {
        Route::get('/materials/receipts/all', [MaterialController::class, 'allReceipts']);
        Route::get('/materials/receipts', [MaterialController::class, 'allReceipts'])->name('materials.receipts');
        Route::get('/materials/receipts/filter', [MaterialController::class, 'filterReceipts']);  
        Route::get('/materials/receipts/{id}/edit', [MaterialController::class, 'editReceipt'])
            ->name('materials.receipts.edit');
        Route::delete('/materials/receipts/{id}', [MaterialController::class, 'deleteReceipt'])
            ->name('materials.receipts.delete');
        Route::put('/materials/receipts/{id}/update', [MaterialController::class, 'updateReceipt'])
            ->name('materials.receipts.update');
    });
});    
// Dashboard
    Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory', [MaterialController::class, 'index'])->name('inventory.index');
    Route::get('/materials/inventory-levels', [MaterialController::class, 'inventoryLevels']);

    
    // Materials Management
    Route::get('/materials/create', [InventoryController::class, 'create'])->name('materials.create');
    Route::post('/materials', [InventoryController::class, 'store'])->name('materials.store');

    // Material Receipt
    Route::get('/receipt/create', [InventoryController::class, 'createReceipt'])->name('materials.receipt.create');
    Route::post('/receipt', [InventoryController::class, 'storeReceipt'])->name('materials.receipt.store');

    // Material Assignment
    Route::get('/assignment/create', [InventoryController::class, 'createAssignment'])->name('materials.assignment.create');
    Route::post('/assignment', [InventoryController::class, 'storeAssignment'])->name('materials.assignment.store');

    Route::get('/materials/internal', [CustomerController::class, 'getInternalMaterials'])
        ->name('materials.internal');

    // Material History
    Route::get('/materials/history/all', [MaterialController::class, 'allHistory']);
    Route::get('/materials/history', [MaterialController::class, 'allHistory'])->name('materials.history');
    Route::get('/materials/history/filter', [MaterialController::class, 'filterHistory']);

    // Edit Receipt Records
    Route::prefix('materials/receipts')->group(function () {
        Route::get('/', [MaterialController::class, 'allReceipts'])->name('materials.receipts');
        Route::get('/filter', [MaterialController::class, 'filterReceipts']);
        Route::get('/{id}/edit', [MaterialController::class, 'editReceipt'])->name('materials.receipts.edit');
        Route::put('/{id}', [MaterialController::class, 'updateReceipt'])->name('materials.receipts.update');
        Route::delete('/{id}', [MaterialController::class, 'deleteReceipt'])->name('materials.receipts.delete');




});

// Material routes
Route::prefix('materials')->group(function () {
    // Static routes first
    Route::get('/', [MaterialController::class, 'index'])->name('materials.index');
    Route::post('/', [MaterialController::class, 'store'])->name('materials.store');
    Route::get('/create', [MaterialController::class, 'create'])->name('materials.create');
    Route::get('/search', [MaterialController::class, 'search'])->name('materials.search');
    Route::get('/internal', [MaterialController::class, 'getInternalMaterials'])->name('materials.internal');
    Route::get('/inventory-levels', [MaterialController::class, 'getInventoryLevels'])->name('materials.inventory-levels');
    Route::post('/assignment', [MaterialController::class, 'recordAssignment'])->name('materials.assignment.store');
    Route::get('/material-usage/history', [MaterialTrackingController::class, 'index'])->name('material_usage.usage_history');



    // Dynamic routes last
    Route::get('/materials', [MaterialController::class, 'index']);
    Route::get('/{material}', [MaterialController::class, 'show'])->name('materials.show');
    Route::get('/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
    Route::put('/{material}', [MaterialController::class, 'update'])->name('materials.update');
    Route::post('/{material}/toggle-status', [MaterialController::class, 'toggleStatus'])->name('materials.toggle-status');
});

// Employee Routes
Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::get('/active', [EmployeeController::class, 'getActiveEmployees'])->name('employees.active');
    Route::post('/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');
});

Route::prefix('employee-progress')->group(function () {
    Route::get('/', [EmployeeProgressController::class, 'index'])->name('employee.progress');
    Route::get('/{employee}', [EmployeeProgressController::class, 'show'])->name('employee.progress.show');
    
    Route::prefix('materials')->group(function () {
        Route::post('/{employee}', [EmployeeProgressController::class, 'storeMaterial'])
            ->name('employee.progress.materials.store');
        Route::put('/{employee}/{material}', [EmployeeProgressController::class, 'updateMaterial'])
            ->name('employee.progress.materials.update');
        Route::delete('/{employee}/{material}', [EmployeeProgressController::class, 'deleteMaterial'])
            ->name('employee.progress.materials.delete');
    });
});
// Customer Routes
Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::get('/active', [CustomerController::class, 'getActiveCustomers'])->name('customers.active');
    Route::get('/search', [CustomerController::class, 'search'])->name('customers.search');
    Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::post('/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
    Route::get('/{customer}/materials', [CustomerController::class, 'getCustomerMaterials'])->name('customers.materials');
    Route::get('/{customer}', [CustomerController::class, 'show'])->name('customers.show');
});


// Material Usage Routes
Route::prefix('material-usage')->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('material_usage');
    })->name('material_usage');
    
    // Weight Recording
    Route::get('/weight-recording', [WeightRecordingController::class, 'index'])->name('material_usage.weight_recording');
    Route::post('/weight-recording/store', [WeightRecordingController::class, 'store'])->name('material_usage.weight_recording.store');


    //usage history
    Route::get('/material-usage/usage-history', [UsageHistoryController::class, 'index'])
    ->name('material_usage.usage_history');

    // Loss Calculation
    Route::get('/loss-calculation', [LossCalculationController::class, 'index'])
    ->name('material_usage.loss_calculation');
    Route::post('/loss-calculation/store', [LossCalculationController::class, 'store'])
    ->name('material_usage.loss_calculation.store');
    Route::post('/loss-calculation/calculate', [LossCalculationController::class, 'calculateLoss'])
    ->name('material_usage.loss_calculation.calculate');
    Route::post('/loss-calculation/status', [LossCalculationController::class, 'getAlertStatus'])
    ->name('material_usage.loss_calculation.status');
    
    // Material Tracking
    Route::get('/tracking', [MaterialTrackingController::class, 'index'])->name('material_usage.tracking');
    Route::get('/tracking/create', [MaterialTrackingController::class, 'create'])->name('material_usage.tracking.create');
    Route::post('/tracking', [MaterialTrackingController::class, 'store'])->name('material_usage.tracking.store');
    Route::get('/tracking/{tracking}/edit', [MaterialTrackingController::class, 'edit'])->name('material_usage.tracking.edit');
    Route::put('/tracking/{tracking}', [MaterialTrackingController::class, 'update'])->name('material_usage.tracking.update');
    Route::delete('/tracking/{tracking}', [MaterialTrackingController::class, 'destroy'])->name('material_usage.tracking.destroy');
    Route::post('/tracking/{tracking}/status', [MaterialTrackingController::class, 'updateStatus'])->name('material_usage.tracking.status');
});
// Profile Route
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Authentication
Route::post('/logout', function () {
    // Add logout logic here when implementing authentication
    return redirect('/');
})->name('logout');

// Database Testing Routes (Development Only)
if (config('app.env') === 'local') {
    Route::get('/test-db', function () {
        try {
            $version = DB::select('SELECT version()');
            $tables = [];
            $tableList = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
            
            foreach ($tableList as $table) {
                $count = DB::table($table->tablename)->count();
                $tables[$table->tablename] = $count;
            }
            
            return [
                'status' => 'success',
                'connection' => 'Connected to PostgreSQL',
                'version' => $version[0]->version,
                'tables' => $tables
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ];
        }
    });
}