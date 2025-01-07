<!DOCTYPE html>
<html lang="en">
<head>
    <title>Material History - King's Jewellery World</title>
    @vite(['resources/css/app.css', 'resources/css/inventory/material-history.css', 'resources/js/app.js'])
</head>
<body>
    @include('layouts.navigation')


    <div class="container mx-auto px-4 max-w-7xl mt-8">
        <!-- Header Section -->
        <div class="bg-[#2C3E50] p-4 rounded-lg mb-8 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <a href="{{ route('inventory.index') }}" class="text-[#4d9dff] hover:text-[#555ae9] font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Return
                </a>
                <span class="text-[#ffffff]">/</span>
                <h2 class="text-2xl font-bold text-[#ffffff]">History</h2>
            </div>
        </div>

        <div class="bg-[#FFFFF0] rounded-lg shadow-lg border border-[none] p-6"> <!-- Ivory background with gold border -->
            <!-- Filter Section -->
            <div class="mb-8 space-y-4">
                <!-- Search Bar Row -->
                <div class="w-full">
                    <input 
                        type="text" 
                        id="searchInput" 
                        placeholder="Search..." 
                        class="w-full p-3 border border-[#333333] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] bg-[#FAF9F6]"
                    >
                </div>
                
                <!-- Filters Row -->
                <div class="flex gap-4">
                    <select id="materialFilter" class="flex-1 p-3 border border-[#333333] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4AF37] bg-[#FAF9F6]">
                        <option value="">All Materials</option>
                        @foreach($history->pluck('material_name')->unique() as $material)
                            <option value="{{ $material }}">{{ $material }}</option>
                        @endforeach
                    </select>

                    <select id="purityFilter" class="flex-1 p-3 border border-[#333333] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4AF37] bg-[#FAF9F6]">
                        <option value="">All Purities</option>
                        @foreach($history->pluck('sub_category')->unique() as $purity)
                            <option value="{{ $purity }}">{{ $purity }}</option>
                        @endforeach
                    </select>

                    <input 
                        type="date" 
                        id="dateFilter" 
                        class="flex-1 p-3 border border-[none] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4AF37] bg-[#FAF9F6]"
                    >

                    <button 
                        id="resetButton" 
                        class="px-6 py-3 bg-[#2C3E50] text-[#FAF9F6] rounded-lg hover:bg-[#4169E1] transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#D4AF37]"
                    >
                        Reset
                    </button>
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto border border-[none] rounded-lg">
                <table class="min-w-full divide-y divide-[#F7E7CE]">
                    <thead class="bg-[#2C3E50]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#ffffff] uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#ffffff] uppercase">Material</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#ffffff] uppercase">Purity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#ffffff] uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#ffffff] uppercase">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#ffffff] uppercase">Entity/Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#ffffff] uppercase">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#FAF9F6] divide-y divide-[#F7E7CE]">
                        @foreach($history as $record)
                            <tr class="hover:bg-[#FFFFF0] transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#333333]">{{ $record->receipt_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#333333]">{{ $record->material_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#333333]">{{ $record->sub_category }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#333333]">{{ $record->receipt_type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#333333]">{{ $record->quantity }} {{ $record->unit }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#333333]">{{ $record->entity_name ?? $record->customer_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#333333]">{{ $record->notes ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('table');
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            const searchInput = document.getElementById('searchInput');
            const materialFilter = document.getElementById('materialFilter');
            const purityFilter = document.getElementById('purityFilter');
            const dateFilter = document.getElementById('dateFilter');
            const resetButton = document.getElementById('resetButton');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const materialValue = materialFilter.value;
                const purityValue = purityFilter.value;
                const dateValue = dateFilter.value;

                rows.forEach(row => {
                    const cells = Array.from(row.getElementsByTagName('td'));
                    const matchesSearch = cells.some(cell => cell.textContent.toLowerCase().includes(searchTerm));
                    const matchesMaterial = !materialValue || cells[1].textContent === materialValue;
                    const matchesPurity = !purityValue || cells[2].textContent === purityValue;
                    const matchesDate = !dateValue || cells[0].textContent.includes(dateValue);

                    row.style.display = matchesSearch && matchesMaterial && matchesPurity && matchesDate ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterTable);
            materialFilter.addEventListener('change', filterTable);
            purityFilter.addEventListener('change', filterTable);
            dateFilter.addEventListener('input', filterTable);

            resetButton.addEventListener('click', function() {
                searchInput.value = '';
                materialFilter.value = '';
                purityFilter.value = '';
                dateFilter.value = '';
                filterTable();
            });
        });
    </script>
</body>
</html>