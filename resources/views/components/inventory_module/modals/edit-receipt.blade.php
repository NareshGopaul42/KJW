<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Receipt - King's Jewellery World</title>
    @vite(['resources/css/app.css', 'resources/css/inventory/edit-receipt.css', 'resources/js/app.js'])
</head>
<body>
    @include('layouts.navigation')

    <div class="container mx-auto px-4 max-w-7xl mt-8">
        <!-- Header Section -->
        <div class="bg-[#2C3E50] p-4 rounded-lg mb-8 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <a href="{{ route('materials.receipts') }}" class="text-[#4d9dff] hover:text-[#555ae9] font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Return
                </a>
                <span class="text-[#ffffff]">/</span>
                <h2 class="text-2xl font-bold text-[#ffffff]">Edit Receipt</h2>
            </div>
        </div>

        <div class="bg-[#FFFFF0] rounded-lg shadow-lg p-6">
            <!-- Form Container -->
            <div class="form-container mx-auto bg-white p-6 rounded-lg shadow-lg">
                <form action="{{ route('materials.receipts.update', $receipt->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Receipt Type -->
                    <div class="form-group">
                        <label>Receipt Type:</label>
                        <div class="segment-control">
                            <input type="radio" id="custom_order" name="receipt_type" value="custom_order" 
                                {{ $receipt->receipt_type === 'custom_order' ? 'checked' : '' }}>
                            <label for="custom_order">Custom Order Material</label>

                            <input type="radio" id="sale_to_store" name="receipt_type" value="sale_to_store" 
                                {{ $receipt->receipt_type === 'sale_to_store' ? 'checked' : '' }}>
                            <label for="sale_to_store">Customer Sale to Store</label>

                            <input type="radio" id="purchase" name="receipt_type" value="purchase" 
                                {{ $receipt->receipt_type === 'purchase' ? 'checked' : '' }}>
                            <label for="purchase">Stock Purchase</label>
                        </div>
                    </div>

                 <!-- Material Type -->
                <div class="form-group">
                    <label for="material_type">Material Type:</label>
                    <select id="material_type" name="material_type" required class="form-input">
                        <option value="">Select Material Type</option>
                        @foreach($materialNames as $type)
                            <option value="{{ $type }}" {{ $receipt->material_type === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Purity (sub_category) -->
                <div class="form-group">
                    <label for="sub_category">Purity:</label>
                    <select id="sub_category" name="sub_category" required class="form-input">
                        <option value="">Select Purity</option>
                        @foreach($subCategories as $subCategory)
                            <option value="{{ $subCategory }}" {{ $receipt->sub_category === $subCategory ? 'selected' : '' }}>
                                {{ $subCategory }}
                            </option>
                        @endforeach
                    </select>
                </div>

                    <!-- Quantity -->
                    <div class="form-group">
                        <label for="quantity">Quantity (DWT):</label>
                        <input type="number" 
                               step="0.001" 
                               min="0" 
                               id="quantity" 
                               name="quantity" 
                               value="{{ $receipt->quantity }}"
                               required 
                               class="form-input no-spin">
                    </div>

                    <!-- Receipt Date -->
                    <div class="form-group">
                        <label for="receipt_date">Receipt Date:</label>
                        <input type="date" 
                               id="receipt_date" 
                               name="receipt_date" 
                               value="{{ $receipt->receipt_date }}"
                               required 
                               class="form-input">
                    </div>

                    <!-- Cost -->
                    <div class="form-group">
                        <label for="cost_per_unit">Cost per DWT:</label>
                        <input type="text" 
                               id="cost_per_unit" 
                               name="cost_per_unit" 
                               value="{{ $receipt->cost_per_unit }}"
                               placeholder="0.00" 
                               required 
                               class="form-input">
                    </div>

                    <!-- Customer Details -->
                    <div id="customer_details" class="p-4 bg-gray-50 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold mb-4">Customer Details</h3>

                        <div class="details-row mb-4 flex gap-4">
                            <input type="text" 
                                   id="customer_first_name" 
                                   name="customer_first_name" 
                                   value="{{ $receipt->customer_first_name }}"
                                   placeholder="First Name" 
                                   class="form-input flex-1">
                            <input type="text" 
                                   id="customer_last_name" 
                                   name="customer_last_name" 
                                   value="{{ $receipt->customer_last_name }}"
                                   placeholder="Last Name" 
                                   class="form-input flex-1">
                        </div>

                        <div class="details-row mb-4 flex gap-4">
                            <input type="email" 
                                   id="customer_email" 
                                   name="customer_email" 
                                   value="{{ $receipt->customer_email }}"
                                   placeholder="Email" 
                                   class="form-input flex-1">
                            <input type="text" 
                                   id="customer_phone" 
                                   name="customer_phone" 
                                   value="{{ $receipt->customer_phone }}"
                                   placeholder="Phone" 
                                   class="form-input flex-1">
                        </div>

                        <textarea id="customer_address" 
                                  name="customer_address" 
                                  placeholder="Address" 
                                  class="form-input mb-4">{{ $receipt->customer_address }}</textarea>

                        <textarea id="notes" 
                                  name="notes" 
                                  placeholder="Notes" 
                                  class="form-input">{{ $receipt->notes }}</textarea>
                    </div>

                 <!-- Submit Button -->
                <div class="flex justify-end mt-6 space-x-4">
                    <a href="{{ route('materials.receipts') }}" 
                    class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-400 transition-colors duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-red-300 text-sm">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-[#4F46E5] text-white rounded-lg hover:bg-[#4338CA] transition-colors duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-[#D4AF37] text-sm">
                        Update Receipt
                    </button>
                </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Material type and subcategory handling
            const materialTypeSelect = document.getElementById('material_type');
            const subCategorySelect = document.getElementById('sub_category');
            const subCategoryGroup = document.getElementById('subcategory_group');

            // Show/hide customer details based on receipt type
            const customerDetails = document.getElementById('customer_details');
            const receiptTypeInputs = document.querySelectorAll('input[name="receipt_type"]');

            function updateCustomerDetailsVisibility() {
                const selectedType = document.querySelector('input[name="receipt_type"]:checked').value;
                customerDetails.style.display = ['custom_order', 'sale_to_store'].includes(selectedType) ? 'block' : 'none';
            }

            receiptTypeInputs.forEach(input => {
                input.addEventListener('change', updateCustomerDetailsVisibility);
            });

            // Initial visibility
            updateCustomerDetailsVisibility();
        });
    </script>
</body>
</html>