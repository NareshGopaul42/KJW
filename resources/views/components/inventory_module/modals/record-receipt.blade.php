<!DOCTYPE html>
<html>
<head>
    <title>Record Receipt - King's Jewellery World</title>
    @vite(['resources/css/app.css', 'resources/css/inventory/record-receipt.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('layouts.navigation')

<!-- Header Section -->
<div class="header">
    <div class="header-content">
        <div class="header-left">
            <a href="{{ route('inventory.index') }}" class="return-link">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Return
            </a>
            <span class="header-title">Record Material Receipt</span>
        </div>
    </div>
</div>


<!-- Error Messages -->
<div class="container mx-auto p-4">
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<!-- Form Container -->
<div class="form-container mx-auto bg-white p-6 rounded-lg shadow-lg">
    <form action="{{ route('materials.receipt.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Receipt Type -->
        <div class="form-group">
            <label>Receipt Type:</label>
            <div class="segment-control">
                <input type="radio" id="custom_order" name="receipt_type" value="custom_order">
                <label for="custom_order">Custom Order Material</label>

                <input type="radio" id="sale_to_store" name="receipt_type" value="sale_to_store" checked>
                <label for="sale_to_store">Customer Sale to Store</label>

                <input type="radio" id="purchase" name="receipt_type" value="purchase">
                <label for="purchase">Stock Purchase</label>
            </div>
        </div>

        <!-- Material Type -->
        <div class="form-group">
            <label for="material_type">Material Type:</label>
            <select id="material_type" name="material_type" required class="form-input">
                <option value="">Select Material Type</option>
                @foreach($materialTypes as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <!-- Sub Category -->
        <div id="subcategory_group" class="form-group" style="display: none;">
            <label for="sub_category">Sub Category:</label>
            <select id="sub_category" name="sub_category" class="form-input">
                <option value="">Select Sub Category</option>
            </select>
        </div>

        <!-- Quantity -->
        <div class="form-group">
            <label for="quantity">Quantity (DWT):</label>
            <input type="number" step="0.001" min="0" id="quantity" name="quantity" required class="form-input no-spin">
        </div>

        <!-- Receipt Date -->
        <div class="form-group">
            <label for="receipt_date">Receipt Date:</label>
            <input type="date" id="receipt_date" name="receipt_date" required class="form-input">
        </div>

        <!-- Cost -->
        <div class="form-group">
            <label for="cost_per_dwt">Cost per DWT:</label>
            <input type="text" id="cost_per_dwt" name="cost_per_dwt" placeholder="0.00" required class="form-input">
        </div>

        <!-- Customer Details -->
        <div id="customer_details" class="p-4 bg-gray-50 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold mb-4">Customer Details</h3>

            <div class="details-row mb-4 flex gap-4">
                <input type="text" id="customer_first_name" name="customer_first_name" placeholder="First Name" class="form-input flex-1">
                <input type="text" id="customer_last_name" name="customer_last_name" placeholder="Last Name" class="form-input flex-1">
            </div>

            <div class="details-row mb-4 flex gap-4">
                <input type="email" id="customer_email" name="customer_email" placeholder="Email" class="form-input flex-1">
                <input type="text" id="customer_phone" name="customer_phone" placeholder="Phone" class="form-input flex-1">
            </div>

            <textarea id="customer_address" name="customer_address" placeholder="Address" class="form-input mb-4"></textarea>

            <textarea id="notes" name="notes" placeholder="Notes" class="form-input"></textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end mt-6">
            <button type="submit" class="submit-button">
                Record Receipt
            </button>
        </div>
    </form>
</div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const receiptTypeRadios = document.querySelectorAll('input[name="receipt_type"]');
                const customerDetails = document.getElementById('customer_details');
                const detailsLabel = document.getElementById('details_label');
                const materialType = document.getElementById('material_type');
                const subCategoryGroup = document.getElementById('subcategory_group');
                const subCategorySelect = document.getElementById('sub_category');
                const subCategories = @json($subCategories);

                // Set default receipt date
                const receiptDateInput = document.getElementById('receipt_date');
                const today = new Date().toISOString().split('T')[0];
                receiptDateInput.value = today;

                // Handle receipt type selection
                receiptTypeRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        detailsLabel.textContent = this.value === 'purchase' ? 'Supplier Details' : 'Customer Details';
                    });
                });

                // Update the event listener for receipt type
                receiptTypeRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        const isSupplier = this.value === 'purchase';
                        detailsLabel.textContent = isSupplier ? 'Supplier Details' : 'Customer Details';
                        
                        // Adjust required fields
                        const customerFields = ['customer_first_name', 'customer_last_name'];
                        customerFields.forEach(field => {
                            const element = document.getElementById(field);
                            element.required = !isSupplier;
                        });
                    });
                });

        // Handle material type changes
        materialType.addEventListener('change', function () {
            const selectedMaterial = this.value;
            subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';

            if (selectedMaterial && subCategories[selectedMaterial]) {
                subCategories[selectedMaterial].forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory;
                    option.textContent = subcategory;
                    subCategorySelect.appendChild(option);
                });
                subCategoryGroup.style.display = 'grid';  // Change this from 'block' to 'grid'
            } else {
                subCategoryGroup.style.display = 'none';
            }
        });

                //Limits costs input to two decimal places

                const input = document.getElementById('cost_per_dwt');

                input.addEventListener('input', function (e) {
                    let value = e.target.value;

                    // Remove invalid characters
                    value = value.replace(/[^0-9.]/g, ''); // Allow only numbers and decimals

                    // Ensure only one decimal point
                    if ((value.match(/\./g) || []).length > 1) {
                        value = value.replace(/\.+$/, ""); // Remove extra dots
                    }

                    // Restrict to 2 decimal places
                    const parts = value.split('.');
                    if (parts.length > 1 && parts[1].length > 2) {
                        parts[1] = parts[1].slice(0, 2);
                        value = parts.join('.');
                    }

                    e.target.value = value; // Update the input value
                });


                
            });
        </script>
   
</body>
</html>
