<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KJW</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dashboard-body">
    <div class="dashboard-container">
        <div class="dashboard-content">
            <div class="dashboard-grid">
                <a href="{{ route('inventory') }}" class="dashboard-item">
                    <h2 class="dashboard-item-title">Inventory Management</h2>
                </a>
                
                <a href="{{ route('inventory') }}" class="dashboard-item">
                    <h2 class="dashboard-item-title">User Maintainance</h2>
                </a>
                
                <a href="{{ route('employee_progress_main') }}" class="dashboard-item">
                    <h2 class="dashboard-item-title">Employee Progress Monitoring</h2>
                </a>
                
                <a href="{{ route('material_usage') }}" class="dashboard-item">
                    <h2 class="dashboard-item-title">Material Usage</h2>
                </a>
            </div>
        </div>
    </div>
</body>
</html>