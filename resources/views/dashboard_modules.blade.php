<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KJW</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Preload Routes -->
    <link rel="preload" href="{{ route('inventory.index') }}" as="document">
    <link rel="preload" href="{{ route('employee.progress') }}" as="document">
    <link rel="preload" href="{{ route('material_usage') }}" as="document">
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Total Materials -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500">Total Materials</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">156</p>
                            <p class="ml-2 text-sm font-medium text-green-600">+5%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Orders -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500">Active Orders</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">24</p>
                            <p class="ml-2 text-sm font-medium text-green-600">+2%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Employees -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="bg-purple-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500">Active Employees</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">12</p>
                            <p class="ml-2 text-sm font-medium text-gray-500">0%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="bg-orange-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500">Pending Tasks</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">8</p>
                            <p class="ml-2 text-sm font-medium text-red-600">-3%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Features Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- Inventory Management -->
            <a href="{{ route('inventory.index') }}" class="group bg-white overflow-hidden shadow rounded-lg transition hover:shadow-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                            </svg>
                        </div>
                        <h3 class="ml-4 text-lg font-medium text-gray-900 group-hover:text-blue-600">
                            Inventory Management
                        </h3>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">
                        Manage inventory levels and track material receipts
                    </p>
                </div>
            </a>

            <!-- User Maintenance -->
            <a href="{{ route('inventory.index') }}" class="group bg-white overflow-hidden shadow rounded-lg transition hover:shadow-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-purple-100 rounded-lg p-3">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h3 class="ml-4 text-lg font-medium text-gray-900 group-hover:text-purple-600">
                            User Maintenance
                        </h3>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">
                        Manage user accounts, roles, and access permissions
                    </p>
                </div>
            </a>

            <!-- Employee Progress Monitoring -->
            <a href="{{ route('employee.progress') }}" class="group bg-white overflow-hidden shadow rounded-lg transition hover:shadow-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-green-100 rounded-lg p-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="ml-4 text-lg font-medium text-gray-900 group-hover:text-green-600">
                            Employee Progress Monitoring
                        </h3>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">
                        Track employee performance and monitor task completion
                    </p>
                </div>
            </a>

            <!-- Material Usage -->
            <a href="{{ route('material_usage') }}" class="group bg-white overflow-hidden shadow rounded-lg transition hover:shadow-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-orange-100 rounded-lg p-3">
                            <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="ml-4 text-lg font-medium text-gray-900 group-hover:text-orange-600">
                            Material Usage
                        </h3>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">
                        Monitor material consumption and track usage patterns
                    </p>
                </div>
            </a>
        </div>
    </div>
</body>
</html>