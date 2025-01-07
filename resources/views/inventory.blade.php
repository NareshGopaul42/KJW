<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management - King's Jewellery World</title>
    @vite(['resources/css/app.css', 'resources/css/inventory_view.css', 'resources/js/app.js', 'resources/css/inventory/add-material.css','resources/css/inventory/record-receipt.css','resources/css/inventory/record-usage.css'])
    <link rel="preload" href="{{ route('materials.receipt.create') }}" as="document">

</head>
<body class="body-inventory">
    @include('layouts.navigation')

    <div class="container-inventory">
        <!-- Header Section -->
        <div class="header-section">
            <div class="flex items-center space-x-2">
                <span class="text-[#4266f7]"></span>
                <a href="{{ route('home') }}" class="text-[#4d9dff] hover:text-[#555ae9] font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Dashboard
                </a>
                <h1 class="page-title text-[#ffffff]"> Receiving</h1>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Add Material Button -->
                <button class="action-button add-material" onclick="window.location.href='{{ route('materials.create') }}'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="button-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Material
                </button>
                
                <!-- Record Receipt Button -->
                <a href="{{ route('materials.receipt.create') }}" class="action-button record-receipt">
                    <svg xmlns="http://www.w3.org/2000/svg" class="button-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                    Record Receipt
                </a>

               <!-- Edit Receipts Button -->
                
                <a href="{{ route('materials.receipts') }}" class="action-button edit-receipts">
                    <svg xmlns="http://www.w3.org/2000/svg" class="button-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16.862 2.487a1.5 1.5 0 0 1 2.121 0l2.528 2.528a1.5 1.5 0 0 1 0 2.121l-10.394 10.394a1.5 1.5 0 0 1-.531.353l-5 1.667a1.5 1.5 0 0 1-1.897-1.897l1.667-5a1.5 1.5 0 0 1 .353-.531l10.394-10.394zm1.06 1.06-10.394 10.394a.5.5 0 0 0-.118.177l-1.34 4.02 4.02-1.34a.5.5 0 0 0 .177-.118l10.394-10.394-2.528-2.528zM20.125 7.875l-2.528-2.528 1.415-1.415 2.528 2.528-1.415 1.415z"/>
                    </svg>
                    Edit Receipts
                </a>>
                        


                
            </div>
        </div>

        <!-- Filter Section -->
        <div class="search-section">
            <div class="inventory-search-container">
                <!-- Dropdown Filter -->
                <select id="categoryFilter" class="inventory-filter-select">
                    <option value="">All Categories</option>
                    <option value="gold">Gold</option>
                    <option value="silver">Silver</option>
                    <option value="platinum">Platinum</option>
                </select>
                <!-- Reset Button -->
                 <button id="resetFilter" class="action-button-secondary">Reset</button>
                
                 <a href="{{ route('materials.history') }}" class="action-button-secondary history-button">
                    History
                 </a>
            </div>
          
        </div>


        <!-- Alert Section -->
        <div id="alertSection" class="alert-section" style="display: none;">
            <div class="alert-container">
                <div class="alert-content">
                    <div class="alert-icon">
                        <svg class="icon-warning" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p id="alertText" class="alert-text"></p>
                </div>
            </div>
        </div>

        <!-- Inventory Grid -->
<div id="inventoryGrid" class="inventory-grid">
    @php
        $groupedMaterials = $materials->groupBy('name');
    @endphp

    @foreach($groupedMaterials as $type => $materialsOfType)
        <div class="material-section mb-8" data-category="{{ strtolower($type) }}">
            <h2 class="text-2xl font-bold mb-4">{{ $type }}</h2>
            <div class="carousel-wrapper">
                <button class="carousel-btn prev"></button>
                <div class="carousel">
                    @foreach($materialsOfType as $material)
                        <div class="material-card">
                            <h3 class="material-title">{{ $material->name }}</h3>
                            <p class="material-type">{{ $material->sub_category }}</p>
                            <div class="card-content">
                                <div class="info-row">
                                    <span class="info-label">Current Stock:</span>
                                    <span class="info-value">{{ number_format($material->current_stock, 3) }} {{ $material->unit }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Min Threshold:</span>
                                    <span class="info-value">{{ number_format($material->minimum_threshold, 3) }} {{ $material->unit }}</span>
                                </div>
                                @if($material->cost_per_dwt)
                                    <div class="info-row">
                                        <span class="info-label">Cost/DWT:</span>
                                        <span class="info-value">${{ number_format($material->cost_per_dwt, 2) }}</span>
                                    </div>
                                @endif
                                <div class="status-badge {{ strtolower(str_replace(' ', '-', $material->status)) }}">
                                    {{ $material->status }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-btn next"></button>
            </div>
        </div>
    @endforeach
</div>
        
        <!-- Pagination -->
        <div id="paginationSection" class="pagination-section">
            <nav class="pagination-container">
                <!-- Pagination will be dynamically inserted here -->
            </nav>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const categoryFilter = document.getElementById('categoryFilter');
        const inventoryGrid = document.getElementById('inventoryGrid');
        const resetFilter = document.getElementById('resetFilter'); // Reset Button
        const searchInput = document.getElementById('searchInput'); // Search Input

        // Function to move selected material type to the top
        function moveRow() {
            const selectedCategory = categoryFilter.value.toLowerCase(); // Get selected category

            // Reset order if "All Categories" is selected
            if (!selectedCategory) {
                resetOrder();
                return;
            }

            // Find and move the selected row based on category
            const selectedRows = Array.from(inventoryGrid.children).filter(row => row.dataset.category === selectedCategory);
            const otherRows = Array.from(inventoryGrid.children).filter(row => row.dataset.category !== selectedCategory);

            // Reorder: Move selected rows to the top
            inventoryGrid.innerHTML = ''; // Clear grid first
            selectedRows.forEach(row => inventoryGrid.appendChild(row)); // Add selected rows first
            otherRows.forEach(row => inventoryGrid.appendChild(row)); // Add other rows afterward
        }

        // Function to reset to initial order
        function resetOrder() {
            const allRows = Array.from(inventoryGrid.children);
            allRows.sort((a, b) => a.dataset.category.localeCompare(b.dataset.category));
            inventoryGrid.innerHTML = ''; // Clear grid
            allRows.forEach(row => inventoryGrid.appendChild(row)); // Append in original order
        }

        // Dropdown Filter Event
        categoryFilter.addEventListener('change', moveRow);

        // Reset Filter Button Event
        resetFilter.addEventListener('click', () => {
            categoryFilter.value = ''; // Clear dropdown selection
            resetOrder(); // Reset order to initial state
        });

     
        // Update Pagination
        function updatePagination(pagination) {
            const paginationContainer = document.querySelector('.pagination-container');

            if (pagination && pagination.total_pages > 1) {
                paginationContainer.innerHTML = `
                    ${pagination.current_page > 1 ? `<a href="#" class="pagination-link" data-page="${pagination.current_page - 1}">Previous</a>` : ''}
                    ${Array.from({ length: pagination.total_pages }, (_, i) => i + 1).map(page => `
                        <a href="#" class="pagination-number ${page === pagination.current_page ? 'active' : ''}" 
                            data-page="${page}">${page}</a>
                    `).join('')}
                    ${pagination.current_page < pagination.total_pages ? `<a href="#" class="pagination-link" data-page="${pagination.current_page + 1}">Next</a>` : ''}
                `;
            } else {
                paginationContainer.innerHTML = '';
            }
        }

        // Pagination Handling
        document.addEventListener('click', function (e) {
            if (e.target.matches('.pagination-link, .pagination-number')) {
                e.preventDefault();
                const page = parseInt(e.target.dataset.page);
                loadInventory(page, searchInput.value, categoryFilter.value);
            }
        });

        // Carousel functionality
        const carousels = document.querySelectorAll('.carousel');

        carousels.forEach(carousel => {
            const prevButton = carousel.parentElement.querySelector('.carousel-btn.prev');
            const nextButton = carousel.parentElement.querySelector('.carousel-btn.next');

            prevButton.addEventListener('click', () => {
                carousel.scrollBy({ left: -220, behavior: 'smooth' });
            });

            nextButton.addEventListener('click', () => {
                carousel.scrollBy({ left: 220, behavior: 'smooth' });
            });
        });

    });

   
        
</script>


    
</body>
</html>