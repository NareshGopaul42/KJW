<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management - King's Jewellery World</title>
    @vite(['resources/css/app.css', 'resources/css/inventory/add-material.css', 'resources/js/app.js'])
</head>
<body>
    @include('layouts.navigation')

    <!-- Header Bar -->
    <div class="header-bar">
        <div class="max-w-2xl mx-auto flex items-center space-x-2">
            <a href="{{ route('inventory.index') }}" class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Return
            </a>
            <span class="text-white font-bold">/ Add New Material</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-2xl mx-auto mt-6">
        <!-- Error Messages -->
        @if(session('error'))
            <div class="error-container">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error-container">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Container -->
        <div class="form-container">
            <form action="{{ route('materials.store') }}" method="POST">
                @csrf
                
                <!-- Material Name -->
                <div class="form-group">
                    <label>Material Name:</label>
                    <input type="text" name="name" maxlength="100" required>
                </div>

                <!-- Sub Category -->
                <div class="form-group">
                    <label>Sub Category:</label>
                    <input type="text" name="sub_category" maxlength="50" required>
                </div>

                <!-- Measurement Unit -->
                <div class="form-group">
                    <label>Measurement Unit:</label>
                    <select name="unit" required>
                        <option value="dwt" selected>Pennyweights (dwt)</option>
                        <option value="grams">Grams (g)</option>
                        <option value="kg">Kilograms (kg)</option>
                        <option value="oz">Ounces (oz)</option>
                        <option value="mg">Milligrams (mg)</option>
                    </select>
                </div>

                <!-- Initial Stock -->
                <div class="form-group">
                    <label>Initial Stock:</label>
                    <input type="number" name="current_stock" min="0" step="0.001">
                </div>

                <!-- Minimum Threshold -->
                <div class="form-group">
                    <label>Minimum Threshold:</label>
                    <input type="number" name="minimum_threshold" min="0" step="0.001" required>
                </div>

                <!-- Cost per DWT -->
                <div class="form-group">
                    <label>Cost per DWT:</label>
                    <input type="text" name="cost_per_dwt" id="cost_per_dwt" placeholder="0.00" required>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-8">
                    <button type="submit" class="submit-button">
                        Add Material
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const costInput = document.getElementById('cost_per_dwt');
            
            costInput.addEventListener('input', function(e) {
                // Remove any non-numeric characters except decimal point
                let value = this.value.replace(/[^\d.]/g, '');
                
                // Ensure only one decimal point
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }
                
                // Format to 2 decimal places if there's a decimal point
                if (parts.length > 1) {
                    value = parts[0] + '.' + parts[1].slice(0, 2);
                }
                
                this.value = value;
            });
        
            // On form submit, ensure the value is numeric
            document.querySelector('form').addEventListener('submit', function(e) {
                const value = costInput.value;
                // Remove dollar sign and commas if present
                costInput.value = value.replace(/[$,]/g, '');
            });
        });
    </script>
</body>
</html>