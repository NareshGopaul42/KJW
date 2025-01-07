<!DOCTYPE html>
<html>
<head>
    <title>Workshop - Loss Calculation</title>
    @vite(['resources/css/app.css', 'resources/css/material_usage/loss_calculation.css'])
</head>
<body class="bg-[#f3f4f6]">
    @include('layouts.navigation')
    
    <div class="breadcrumb">
        MATERIAL USAGE → Loss Calculation
    </div>

    <div class="card-container">
        <div class="loss-card">
            <h2 class="card-title">Loss Calculation</h2>
            
            <form action="{{ route('material_usage.loss_calculation.store') }}" method="POST">
                @csrf
                
                <!-- Add error messages display -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            
                <!-- Add success message display -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            
                <!-- Add error message display -->
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            
                <div class="grid-container">
                    <div class="field-group">
                        <label class="field-label">Employee ID</label>
                        <select class="field-input" name="employee_id" required>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->employee_id }}">{{ $employee->proper_name }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="field-group">
                        <label class="field-label">Material ID</label>
                        <select class="field-input" name="material_id" required>
                            @foreach($materials as $material)
                                <option value="{{ $material->material_id }}">{{ $material->material_id }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="field-group">
                        <label class="field-label">Job ID</label>
                        <select class="field-input" name="job_id" required>
                            @foreach($jobs as $job)
                                <option value="{{ $job->id }}">{{ $job->queue }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="field-group">
                        <label class="field-label">Initial Weight</label>
                        <div class="input-with-unit">
                            <input type="number" class="field-input" name="init_weight" id="init_weight" step="0.1" required>
                            <span class="unit">dwt</span>
                        </div>
                    </div>
            
                    <div class="field-group">
                        <label class="field-label">Final Weight</label>
                        <div class="input-with-unit">
                            <input type="number" class="field-input" name="final_weight" id="final_weight" step="0.1" required oninput="calculateLoss()">
                            <span class="unit">dwt</span>
                        </div>
                    </div>
            
                    <div class="field-group">
                        <label class="field-label">Loss Amount</label>
                        <div class="input-with-unit">
                            <input type="number" class="field-input" name="loss_amt" id="loss_amt" readonly>
                            <span class="unit">dwt</span>
                        </div>
                    </div>
            
                    <div class="field-group">
                        <label class="field-label">Loss Percentage</label>
                        <div class="input-with-unit">
                            <input type="number" class="field-input" name="loss_percent" id="loss_percent" readonly>
                            <span class="unit">%</span>
                        </div>
                    </div>
                </div>
            
                <div class="button-group">
                    <a href="{{ route('material_usage') }}" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-confirm">Confirm</button>
                </div>
            </form>
            
            <script>
                function calculateLoss() {
                    const initialWeight = parseFloat(document.getElementById('init_weight').value) || 0;
                    const finalWeight = parseFloat(document.getElementById('final_weight').value) || 0;
            
                    // Calculate loss amount
                    const lossAmount = initialWeight - finalWeight;
                    document.getElementById('loss_amt').value = lossAmount.toFixed(2);
            
                    // Calculate loss percentage
                    const lossPercentage = initialWeight > 0 ? (lossAmount / initialWeight) * 100 : 0;
                    document.getElementById('loss_percent').value = lossPercentage.toFixed(2);
                }
            
                // Also trigger calculation when initial weight changes
                document.getElementById('init_weight').addEventListener('input', calculateLoss);
            </script>