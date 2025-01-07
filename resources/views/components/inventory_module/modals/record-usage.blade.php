<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Material Usage - King's Jewellery World</title>
    @vite(['resources/css/app.css','resources/css/inventory/record-usage.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('layouts.navigation')

    <div class="container mx-auto my-8 max-w-3xl bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('inventory.index') }}" class="text-indigo-500 hover:text-indigo-600 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Return
            </a>
            <h2 class="text-2xl font-bold">Record Material Usage</h2>
        </div>

        <!-- Display Validation Errors -->
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

        <!-- Form -->
        <form action="{{ route('materials.assignment.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Job Type Selection -->
            <div class="form-group">
                <label>Job Type:</label>
                <div class="segment-control">
                    <input type="radio" id="customerOrder" name="job_type" value="customer_order">
                    <label for="customerOrder">Customer Repair</label>

                    <input type="radio" id="customOrder" name="job_type" value="custom_order">
                    <label for="customOrder">Custom Order</label>

                    <input type="radio" id="internalOrder" name="job_type" value="internal_order">
                    <label for="internalOrder">Internal Production</label>
                </div>
            </div>
            
            <!-- Employee Selection -->
            <div class="form-group">
                <label for="employee_id">Employee:</label>
                <select id="employee_id" name="employee_id" required class="form-input">
                    <option value="">Select Employee</option>
                    <!-- Employees populated dynamically -->
                </select>
            </div>

            <div class="form-group">
                <label for="customer_id">Customer:</label>
                <select id="customer_id" name="customer_id" class="form-input">
                    <option value="">Select Customer</option>
                </select>
            </div>
            

           <!-- Material Selection Group -->
                <div class="space-y-4">
                <!-- Main Material Type -->
                <div class="form-group">
                    <label for="material_type">Material Type:</label>
                    <select id="material_type" name="material_type" required class="form-input">
                        <option value="">Select Material Type</option>
                        <!-- Main materials populated here -->
                    </select>
                </div>

                <!-- Material Purity -->
                <div class="form-group">
                    <label for="material_purity">Material Purity:</label>
                    <select id="material_purity" name="material_purity" required class="form-input" disabled>
                        <option value="">Select Material Type First</option>
                        <!-- Purities populated dynamically -->
                    </select>
                </div>
            </div>

            <!-- Initial Weight -->
            <div class="form-group">
                <label for="weight_assigned">Initial Weight (DWT):</label>
                <input type="number" step="0.001" min="0" id="weight_assigned" name="weight_assigned" value="{{ old('weight_assigned') }}" required class="form-input">
            </div>

            <!-- Task Description -->
            <div class="form-group">
                <label for="task_description">Task Description:</label>
                <textarea id="task_description" name="task_description" rows="3" required class="form-input">{{ old('task_description') }}</textarea>
            </div>

            <!-- Date Assigned -->
            <div class="form-group">
                <label for="date_assigned">Date Assigned:</label>
                <input type="date" id="date_assigned" name="date_assigned" value="{{ old('date_assigned', now()->toDateString()) }}" required class="form-input">
            </div>

            <!-- Expected Completion Date -->
            <div class="form-group">
                <label for="date_due">Expected Completion Date:</label>
                <input type="date" id="date_due" name="date_due" value="{{ old('date_due') }}" required class="form-input">
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label for="notes">Additional Notes:</label>
                <textarea id="notes" name="notes" rows="3" class="form-input">{{ old('notes') }}</textarea>
            </div>

            <!-- Submit -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Record Usage
                </button>
            </div>
        </form>

        <!-- JavaScript -->
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Constants
                const employees = @json($employees);
                const jobTypeRadios = document.querySelectorAll('input[name="job_type"]');
                const customerSelect = document.getElementById('customer_id');
                const employeeSelect = document.getElementById('employee_id');
                const materialTypeSelect = document.getElementById('material_type');
                const materialPuritySelect = document.getElementById('material_purity');
                const dateAssignedInput = document.getElementById('date_assigned');
                const dateDueInput = document.getElementById('date_due');
                const form = document.querySelector('form');
        
                // Set minimum dates for date inputs
                const today = new Date().toISOString().split('T')[0];
                dateAssignedInput.min = today;
                dateDueInput.min = today;
                
                // Date change handler
                dateAssignedInput.addEventListener('change', function() {
                    dateDueInput.min = this.value;
                    if (dateDueInput.value && dateDueInput.value < this.value) {
                        dateDueInput.value = this.value;
                    }
                });
        
                // Populate employees
                employeeSelect.innerHTML = '<option value="">Select Employee</option>';
                employees.forEach(employee => {
                    const option = document.createElement('option');
                    option.value = employee.employee_id;
                    option.textContent = `${employee.proper_name} - ${employee.role}`;
                    employeeSelect.appendChild(option);
                });
        
                // Job type changes
                jobTypeRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const jobType = this.value;
                        console.log('Job type changed:', jobType);
                        
                        if (jobType === 'internal_order') {
                            customerSelect.value = '';
                            customerSelect.disabled = true;
                            materialTypeSelect.disabled = false;
                            
                            // Fetch internal materials
                            materialTypeSelect.innerHTML = '<option value="">Loading materials...</option>';
                            materialPuritySelect.innerHTML = '<option value="">Select Material Type First</option>';
                            materialPuritySelect.disabled = true;
                            
                            fetch('/materials/internal')
                                .then(response => response.json())
                                .then(response => {
                                    console.log('Internal materials response:', response);
                                    
                                    const materials = response.materials || [];
                                    materialTypeSelect.disabled = false;
                                    materialTypeSelect.innerHTML = '<option value="">Select Material Type</option>';
                                    
                                    if (!materials || materials.length === 0) {
                                        materialTypeSelect.innerHTML = '<option value="">No materials available</option>';
                                        return;
                                    }
        
                                    // Group materials by type and purity
                                    const uniqueMaterials = {};
                                    materials.forEach(material => {
                                        const type = material.material_type;
                                        const purity = material.sub_category;
                                        const weight = parseFloat(material.total_weight);
                const materialId = material.material_id; // Ensure we get the material_id
                                        
                                        if (!uniqueMaterials[type]) {
                                            uniqueMaterials[type] = {
                        materialId: materialId, // Store the actual material_id
                                                totalWeight: 0,
                                                purities: {}
                                            };
                                        }
                                        
                                        if (!uniqueMaterials[type].purities[purity]) {
                                            uniqueMaterials[type].purities[purity] = 0;
                                        }
                                        
                                        uniqueMaterials[type].totalWeight += weight;
                                        uniqueMaterials[type].purities[purity] += weight;
                                    });
        
                                    // Populate material types dropdown
                                    Object.entries(uniqueMaterials).forEach(([type, info]) => {
                                        const option = document.createElement('option');
                                        option.value = info.materialId;
                                        option.textContent = `${type} (${info.totalWeight.toFixed(3)} DWT Total)`;
                                        materialTypeSelect.appendChild(option);
                                    });
        
                                    materialTypeSelect.dataset.materials = JSON.stringify(uniqueMaterials);
                                })
                                .catch(error => {
                                    console.error('Error fetching internal materials:', error);
                                    materialTypeSelect.innerHTML = '<option value="">Error loading materials</option>';
                                    materialPuritySelect.disabled = true;
                                });
                        } else {
                            customerSelect.disabled = false;
                            materialTypeSelect.disabled = !customerSelect.value;
                            materialTypeSelect.innerHTML = '<option value="">Select Customer First</option>';
                            materialPuritySelect.innerHTML = '<option value="">Select Material Type First</option>';
                            materialPuritySelect.disabled = true;
                        }
                    });
                });
        
                // Fetch and populate active customers
                // Fetch and populate active customers
            fetch('/customers/active')
                .then(response => response.json())
                .then(customers => {
                    console.log('Fetched customers:', customers);

                    // Clear existing options
                    customerSelect.innerHTML = '<option value="">Select Customer</option>';

                    // Create and append new options
                    customers.forEach(customer => {
                        const option = document.createElement('option');
                        option.value = customer.customer_id;
                        option.textContent = `${customer.first_name} ${customer.last_name}${customer.phone ? ' - ' + customer.phone : ''}`;
                        customerSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching customers:', error);
                    customerSelect.innerHTML = '<option value="">Error loading customers</option>';
                });
                  
                // Customer selection handler
                customerSelect.addEventListener('change', function() {
                    if (this.value) {
                        const jobType = document.querySelector('input[name="job_type"]:checked')?.value;
                        console.log('Customer selection changed:', {
                            customerId: this.value,
                            jobType: jobType
                        });
                        
                        if (jobType === 'customer_order' || jobType === 'customer_repair') {
                            const url = `/customers/${this.value}/materials?type=${jobType}`;
                            console.log('Fetching materials:', { url });
                            
                            materialTypeSelect.innerHTML = '<option value="">Loading materials...</option>';
                            materialTypeSelect.disabled = true;
                            materialPuritySelect.innerHTML = '<option value="">Select Material Type First</option>';
                            materialPuritySelect.disabled = true;
                            
                            fetch(url)
                                .then(response => response.json())
                                .then(response => {
                                    console.log('Raw server response:', response);
                                    const materials = response.materials?.['Illuminate\\Support\\Collection'] || [];
                                    
                                    materialTypeSelect.disabled = false;
                                    materialTypeSelect.innerHTML = '<option value="">Select Material Type</option>';
                                    
                                    if (!materials || materials.length === 0) {
                                        materialTypeSelect.innerHTML = '<option value="">No materials found for this customer</option>';
                                        return;
                                    }
        
                                    // Group materials by type and purity
                                    const uniqueMaterials = {};
                                    materials.forEach(material => {
                                        const type = material.material_type;
                                        const purity = material.sub_category;
                                        const weight = parseFloat(material.total_weight);
                                        
                                        if (!uniqueMaterials[type]) {
                                            uniqueMaterials[type] = {
                                                materialId: material.material_id,
                                                totalWeight: 0,
                                                purities: {}
                                            };
                                        }
                                        
                                        if (!uniqueMaterials[type].purities[purity]) {
                                            uniqueMaterials[type].purities[purity] = 0;
                                        }
                                        
                                        uniqueMaterials[type].totalWeight += weight;
                                        uniqueMaterials[type].purities[purity] += weight;
                                    });
        
                                    // Populate material types dropdown
                                    Object.entries(uniqueMaterials).forEach(([type, info]) => {
                                        const option = document.createElement('option');
                                        option.value = info.materialId;
                                        option.textContent = `${type} (${info.totalWeight.toFixed(3)} DWT Total)`;
                                        materialTypeSelect.appendChild(option);
                                    });
        
                                    materialTypeSelect.dataset.materials = JSON.stringify(uniqueMaterials);
                                })
                                .catch(error => {
                                    console.error('Error fetching materials:', error);
                                    materialTypeSelect.innerHTML = '<option value="">Error loading materials</option>';
                                    materialPuritySelect.disabled = true;
                                });
                        }
                    } else {
                        materialTypeSelect.innerHTML = '<option value="">Select Customer First</option>';
                        materialTypeSelect.disabled = true;
                        materialPuritySelect.innerHTML = '<option value="">Select Material Type First</option>';
                        materialPuritySelect.disabled = true;
                    }
                });
        
                // Material type selection handler
                materialTypeSelect.addEventListener('change', function() {
                    materialPuritySelect.innerHTML = '<option value="">Select Purity</option>';
        
                    if (this.value && this.dataset.materials) {
                        const materials = JSON.parse(this.dataset.materials);
                        const selectedType = this.options[this.selectedIndex].text.split(' (')[0];
                        const selectedMaterial = Object.entries(materials).find(([type]) => type === selectedType)?.[1];
        
                        if (selectedMaterial) {
                            materialPuritySelect.disabled = false;
                            
                            Object.entries(selectedMaterial.purities).forEach(([purity, weight]) => {
                                const option = document.createElement('option');
                                option.value = selectedMaterial.materialId;
                                option.textContent = `${purity} (${weight.toFixed(3)} DWT)`;
                                materialPuritySelect.appendChild(option);
                            });
                        }
                    } else {
                        materialPuritySelect.disabled = true;
                    }
                });
        
                // Form validation
                form.addEventListener('submit', function(e) {
                    const jobType = document.querySelector('input[name="job_type"]:checked')?.value;
                    const weightAssigned = document.getElementById('weight_assigned').value;
                    const taskDescription = document.getElementById('task_description').value;
        
                    if (!jobType) {
                        e.preventDefault();
                        alert('Please select a job type');
                        return;
                    }
        
                    if (!employeeSelect.value) {
                        e.preventDefault();
                        alert('Please select an employee');
                        return;
                    }
        
                    // Only validate customer selection for non-internal orders
                    if (jobType !== 'internal_order' && !customerSelect.value) {
                        e.preventDefault();
                        alert('Please select a customer');
                        return;
                    }
        
                    if (!materialTypeSelect.value) {
                        e.preventDefault();
                        alert('Please select a material type');
                        return;
                    }
        
                    if (!materialPuritySelect.value) {
                        e.preventDefault();
                        alert('Please select material purity');
                        return;
                    }
        
                    if (!weightAssigned || weightAssigned <= 0) {
                        e.preventDefault();
                        alert('Please enter a valid weight');
                        return;
                    }
        
                    if (!taskDescription.trim()) {
                        e.preventDefault();
                        alert('Please enter a task description');
                        return;
                    }
        
                    // Add workshop type for internal orders
                    if (jobType === 'internal_order') {
                        const workshopInput = document.createElement('input');
                        workshopInput.type = 'hidden';
                        workshopInput.name = 'workshop';
                        workshopInput.value = 'internal';
                        form.appendChild(workshopInput);
                    }
                });
            });
        </script>

    </div>
</body>
</html>