<!DOCTYPE html>
<html>
<head>
    <title>Material Usage - KJW</title>
    @vite(['resources/css/app.css', 'resources/css/material_usage/material_usage.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50">
    @include('layouts.navigation')
    
    <!-- Header Section -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-indigo-500 hover:text-indigo-600 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Dashboard
                    </a>
                    <span class="mx-2 text-gray-300">/</span>
                    <h1 class="text-2xl font-semibold text-gray-900">Material Usage</h1>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500">Today's Usage</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">1.2 kg</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500">Active Records</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">24</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="bg-orange-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500">Pending Tasks</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">8</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="bg-red-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500">Material Loss</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">2.5%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature Cards Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- Weight Recording -->
            <a href="{{ route('material_usage.weight_recording') }}" class="group bg-white overflow-hidden shadow rounded-lg transition hover:shadow-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                            </svg>
                        </div>
                        <h3 class="ml-4 text-lg font-medium text-gray-900 group-hover:text-blue-600">
                            Weight Recording
                        </h3>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">
                        Record and track material weights throughout the production process
                    </p>
                </div>
            </a>

            <!-- Loss Calculation -->
            <a href="{{ route('material_usage.loss_calculation') }}" class="group bg-white overflow-hidden shadow rounded-lg transition hover:shadow-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-red-100 rounded-lg p-3">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                            </svg>
                        </div>
                        <h3 class="ml-4 text-lg font-medium text-gray-900 group-hover:text-red-600">
                            Loss Calculation
                        </h3>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">
                        Calculate and analyze material loss during production
                    </p>
                </div>
            </a>

            <!-- Material Tracking -->
            <a href="{{ route('material_usage.tracking') }}" class="group bg-white overflow-hidden shadow rounded-lg transition hover:shadow-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-green-100 rounded-lg p-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <h3 class="ml-4 text-lg font-medium text-gray-900 group-hover:text-green-600">
                            Material Tracking
                        </h3>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">
                        Track material movement and usage throughout production
                    </p>
                </div>
            </a>

            <!-- Usage History -->
            <a href="{{ route('material_usage.usage_history') }}" class="group bg-white overflow-hidden shadow rounded-lg transition hover:shadow-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-purple-100 rounded-lg p-3">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="ml-4 text-lg font-medium text-gray-900 group-hover:text-purple-600">
                            Usage History
                        </h3>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">
                        View and analyze historical material usage data
                    </p>
                </div>
            </a>
        </div>
    </div>
</body>
</html>