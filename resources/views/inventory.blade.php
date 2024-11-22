<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management - King's Jewelry World</title>
    @vite(['resources/css/app.css', 'resources/css/inventory.css', 'resources/js/app.js'])
</head>
<body class="body-inventory">
    @include('layouts.navigation')

    <div class="container-inventory">
        <!-- Header Section -->
        <div class="header-section">
            <h1 class="page-title">Inventory Management</h1>
            <div class="button-group">
                <!-- Add Material Button -->
                <button class="action-button add-material">
                    <svg xmlns="http://www.w3.org/2000/svg" class="button-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Material
                </button>
                
                <!-- Record Receipt Button -->
                <button class="action-button record-receipt">
                    <svg xmlns="http://www.w3.org/2000/svg" class="button-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                    Record Receipt
                </button>

                <!-- Record Usage Button -->
                <button class="action-button record-usage">
                    <svg xmlns="http://www.w3.org/2000/svg" class="button-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z" />
                    </svg>
                    Record Usage
                </button>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="search-section">
            <div class="inventory-search-container">
                <input type="text" 
                       placeholder="Search materials..." 
                       class="search-input">
                <select class="inventory-filter-select">
                    <option value="">All Categories</option>
                    <option value="gold">Gold</option>
                    <option value="silver">Silver</option>
                    <option value="platinum">Platinum</option>
                </select>
            </div>
        </div>

        <!-- Alert Section -->
        <div class="alert-section">
            <div class="alert-container">
                <div class="alert-content">
                    <div class="alert-icon">
                        <svg class="icon-warning" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="alert-text">2 materials are below minimum threshold</p>
                </div>
            </div>
        </div>

      <!-- Inventory Grid -->
        <div class="inventory-grid">
            <!-- Material Card -->
            <div class="material-card">
                <div class="card-header">
                    <div>
                        <h3 class="material-title">24K Gold</h3>
                        <p class="material-type">Raw Material</p>
                    </div>
                    <span class="status-badge in-stock">In Stock</span>
                </div>
                <div class="card-content">
                    <!-- Business Stock -->
                    <div class="info-row">
                        <span class="info-label">Business Stock:</span>
                        <span class="info-value">1250.50 dwt</span>
                    </div>
                    <!-- Customer Materials -->
                    <div class="info-row">
                        <span class="info-label">Customer Materials:</span>
                        <span class="info-value">450.25 dwt</span>
                    </div>
                    <!-- Minimum Threshold -->
                    <div class="info-row">
                        <span class="info-label">Minimum Threshold:</span>
                        <span class="info-value">1000 dwt</span>
                    </div>
                    <!-- Current Price -->
                    <div class="info-row">
                        <span class="info-label">Current Price:</span>
                        <span class="info-value">$45.00/dwt</span>
                    </div>
                </div>
                <div class="card-actions">
                    <button class="action-button-secondary">View History</button>
                    <button class="action-button-primary">Stock Adjustment</button>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination-section">
            <nav class="pagination-container">
                <a href="#" class="pagination-link">Previous</a>
                <a href="#" class="pagination-number">1</a>
                <a href="#" class="pagination-number">2</a>
                <a href="#" class="pagination-number">3</a>
                <a href="#" class="pagination-link">Next</a>
            </nav>
        </div>
    </div>
</body>
</html>