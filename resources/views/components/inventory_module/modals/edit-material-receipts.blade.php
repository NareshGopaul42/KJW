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
                <h2 class="text-2xl font-bold text-[#ffffff]">Edit Receipts</h2>
            </div>
        </div>

        <div class="bg-[#FFFFF0] rounded-lg shadow-lg border border-[none] p-6">
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

<!-- Table Section -->
<div class="overflow-x-auto border border-[none] rounded-lg">
    <table class="min-w-full divide-y divide-[#F7E7CE]">
        <thead class="bg-[#2C3E50]">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#ffffff] uppercase w-24">Date</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#ffffff] uppercase w-28">Material</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#ffffff] uppercase w-20">Purity</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#ffffff] uppercase w-20">Type</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#ffffff] uppercase w-24">Quantity</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#ffffff] uppercase w-32">Entity/Customer</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#ffffff] uppercase">Notes</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#ffffff] uppercase w-20">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-[#FAF9F6] divide-y divide-[#F7E7CE]">
            @foreach($history as $record)
                <tr class="hover:bg-[#FFFFF0] transition-colors duration-150">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">{{ $record->receipt_date }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">{{ $record->material_name }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">{{ $record->sub_category }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">{{ $record->receipt_type }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">{{ $record->quantity }} {{ $record->unit }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">{{ $record->receipt_type === 'purchase' ? $record->entity_name : $record->customer_name ?? 'N/A' }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">{{ $record->notes ?? 'N/A' }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333] flex items-center space-x-4">
                        <a href="{{ route('materials.receipts.edit', $record->id) }}" class="text-[#4d9dff] hover:text-[#555ae9] cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z"/>
                            </svg>
                        </a>
                        
                        <form id="delete-form-{{ $record->id }}" action="{{ route('materials.receipts.delete', $record->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-[#e3342f] hover:text-[#ff6a65] cursor-pointer"
                                    onclick="return confirm('Are you sure you want to delete this receipt?')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const table = document.querySelector('table');
    const tbody = table.querySelector('tbody');
    const searchInput = document.getElementById('searchInput');
    const materialFilter = document.getElementById('materialFilter');
    const purityFilter = document.getElementById('purityFilter');
    const dateFilter = document.getElementById('dateFilter');
    const resetButton = document.getElementById('resetButton');

    async function refreshTable() {
        try {
            const response = await fetch('/api/materials/history', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) throw new Error('Failed to fetch data');
            
            const data = await response.json();
            updateTableContent(data);
            filterTable(); // Apply current filters to new data
        } catch (error) {
            console.error('Error refreshing table:', error);
        }
    }

    function updateTableContent(data) {
    tbody.innerHTML = data.map(record => `
        <tr class="hover:bg-[#FFFFF0] transition-colors duration-150">
            <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">${record.receipt_date}</td>
            <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">${record.material.name}</td>
            <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">${record.sub_category}</td>
            <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">${record.receipt_type}</td>
            <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">${record.quantity} ${record.unit}</td>
            <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">
                ${record.receipt_type === 'purchase' 
                    ? (record.entity ? record.entity.name : 'N/A')
                    : (record.customer ? `${record.customer.first_name} ${record.customer.last_name}` : 'N/A')}
            </td>
            <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333]">${record.notes || 'N/A'}</td>
            <td class="px-4 py-2 whitespace-nowrap text-sm text-[#333333] flex items-center space-x-4">
                <a href="/materials/receipts/${record.id}/edit" class="text-[#4d9dff] hover:text-[#555ae9] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z"/>
                    </svg>
                </a>
                <a href="#" onclick="deleteRecord(${record.id}, event)" class="text-[#e3342f] hover:text-[#ff6a65] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                    </svg>
                </a>
            </td>
        </tr>
    `).join('');
}
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const materialValue = materialFilter.value;
        const purityValue = purityFilter.value;
        const dateValue = dateFilter.value;
        const rows = Array.from(tbody.getElementsByTagName('tr'));

        rows.forEach(row => {
            const cells = Array.from(row.getElementsByTagName('td'));
            const matchesSearch = cells.some(cell => cell.textContent.toLowerCase().includes(searchTerm));
            const matchesMaterial = !materialValue || cells[1].textContent === materialValue;
            const matchesPurity = !purityValue || cells[2].textContent === purityValue;
            const matchesDate = !dateValue || cells[0].textContent.includes(dateValue);

            row.style.display = matchesSearch && matchesMaterial && matchesPurity && matchesDate ? '' : 'none';
        });
    }

    async function deleteRecord(id, event) {
        event.preventDefault();
        if (!confirm('Are you sure you want to delete this receipt?')) return;

        try {
            const response = await fetch(`/materials/receipts/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Failed to delete receipt');
            
            await refreshTable();
        } catch (error) {
            console.error('Error deleting record:', error);
            alert('Failed to delete receipt');
        }
    }

    window.deleteRecord = deleteRecord; // Make function available globally

    // Event listeners
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

    // Refresh table when returning from edit page
    if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
        refreshTable();
    }
});
    </script>
</body>
</html>