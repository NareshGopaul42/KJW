<?php

namespace App\Http\Controllers\Material_Usage;

use App\Http\Controllers\Controller;
use App\Models\Material_Usage\material_tracking as MaterialTracking;
use Illuminate\Http\Request;

class MaterialTrackingController extends Controller
{
    /**
     * Display a listing of the material tracking records.
     */
    public function index(Request $request)
    {
        $trackings = MaterialTracking::query()
            ->when($request->search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('material_id', 'like', "%{$search}%")
                      ->orWhere('batch_number', 'like', "%{$search}%")
                      ->orWhere('customer', 'like', "%{$search}%")
                      ->orWhere('storage', 'like', "%{$search}%")
                      ->orWhere('assigned_to', 'like', "%{$search}%");
                });
            })
            ->orderBy('date_received', 'desc')
            ->paginate(15);

        return view('material-tracking.index', compact('trackings'));
    }

    /**
     * Show the form for creating a new material tracking record.
     */
    public function create()
    {
        return view('material_usage.material_tracking.create');
    }

    /**
     * Store a newly created material tracking record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|string|max:255',
            'batch_number' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'amount_received' => 'required|numeric|min:0',
            'date_received' => 'required|date',
            'unit_of_measure' => 'required|string|max:50',
            'storage' => 'required|string|max:255',
            'assigned_to' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed'
        ]);
        
        MaterialTracking::create($validated);
        
        return redirect()->route('material_usage.tracking')
            ->with('success', 'Material tracking record created successfully.');
    }

    /**
     * Show the form for editing the specified material tracking record.
     */
    public function edit(MaterialTracking $tracking)
    {
        return view('material_usage.material_tracking.edit', compact('tracking'));
    }

    /**
     * Update the specified material tracking record.
     */
    public function update(Request $request, MaterialTracking $tracking)
    {
        $validated = $request->validate([
            'material_id' => 'required|string|max:255',
            'batch_number' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'amount_received' => 'required|numeric|min:0',
            'date_received' => 'required|date',
            'unit_of_measure' => 'required|string|max:50',
            'storage' => 'required|string|max:255',
            'assigned_to' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed'
        ]);
        
        $tracking->update($validated);
        
        return redirect()->route('material_usage.tracking')
            ->with('success', 'Material tracking record updated successfully.');
    }

    /**
     * Remove the specified material tracking record.
     */
    public function destroy(MaterialTracking $tracking)
    {
        $tracking->delete();
        
        return redirect()->route('material_usage.tracking')
            ->with('success', 'Material tracking record deleted successfully.');
    }

    /**
     * Update the status of a material tracking record.
     */
    public function updateStatus(Request $request, MaterialTracking $tracking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        $tracking->status = $validated['status'];
        $tracking->save();
        
        return redirect()->back()
            ->with('success', 'Material status updated successfully.');
    }
}