@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex flex-column h-100 overflow-auto">
                <div class="p-3 p-md-4">
                    <!-- Page Header -->
                    <div class="mb-4">
                        <h1 class="h3 mb-3 text-dark">Data Bangunan</h1>

                        <!-- Search and Filter -->
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-4">
                                <div class="position-relative">
                                
                                    <input 
                                        type="text" 
                                        class="form-control ps-5" 
                                        placeholder="Cari..."
                                        id="searchQuery"
                                        value="{{ request('search') }}"
                                    >
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <select class="form-select" id="filterType">
                                    <option value="bangunan">Bangunan</option>
                                    <option value="tower">Tower</option>
                                    <option value="lantai">Lantai</option>
                                    <option value="unit">Unit Hunian</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="dataTable">
                                    <thead class="table-light">
                                        <!-- Header will be dynamically populated by JavaScript -->
                                    </thead>
                                    <tbody>
                                        <!-- Data will be dynamically populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Mock data - (APIunpar) Replace with actual API data from Unpar
const buildingsData = [
    { id: "1", name: "Gedung Rektorat", address: "Jl. Telekomunikasi No. 1, Bandung", towers: 2, floors: 8, units: 64 },
    { id: "2", name: "Gedung Perpustakaan", address: "Jl. Telekomunikasi No. 2, Bandung", towers: 1, floors: 5, units: 30 },
    { id: "3", name: "Gedung Fakultas Teknik", address: "Jl. Telekomunikasi No. 3, Bandung", towers: 3, floors: 10, units: 120 },
    { id: "4", name: "Gedung Fakultas Ekonomi", address: "Jl. Telekomunikasi No. 4, Bandung", towers: 2, floors: 7, units: 84 },
    { id: "5", name: "Gedung Student Center", address: "Jl. Telekomunikasi No. 5, Bandung", towers: 1, floors: 4, units: 24 },
    { id: "6", name: "Gedung Laboratorium", address: "Jl. Telekomunikasi No. 6, Bandung", towers: 2, floors: 6, units: 48 },
];

const towersData = [
    { id: "1", towerName: "Tower A", buildingName: "Gedung Rektorat", floors: 8, units: 32 },
    { id: "2", towerName: "Tower B", buildingName: "Gedung Rektorat", floors: 8, units: 32 },
    { id: "3", towerName: "Tower A", buildingName: "Gedung Fakultas Teknik", floors: 10, units: 40 },
    { id: "4", towerName: "Tower B", buildingName: "Gedung Fakultas Teknik", floors: 10, units: 40 },
    { id: "5", towerName: "Tower C", buildingName: "Gedung Fakultas Teknik", floors: 10, units: 40 },
    { id: "6", towerName: "Tower A", buildingName: "Gedung Fakultas Ekonomi", floors: 7, units: 42 },
    { id: "7", towerName: "Tower B", buildingName: "Gedung Fakultas Ekonomi", floors: 7, units: 42 },
];

const floorsData = [
    { id: "1", floorName: "Lantai 1", towerName: "Tower A", buildingName: "Gedung Rektorat", units: 4 },
    { id: "2", floorName: "Lantai 2", towerName: "Tower A", buildingName: "Gedung Rektorat", units: 4 },
    { id: "3", floorName: "Lantai 3", towerName: "Tower A", buildingName: "Gedung Rektorat", units: 4 },
    { id: "4", floorName: "Lantai 4", towerName: "Tower A", buildingName: "Gedung Rektorat", units: 4 },
    { id: "5", floorName: "Lantai 5", towerName: "Tower A", buildingName: "Gedung Rektorat", units: 4 },
    { id: "6", floorName: "Lantai 1", towerName: "Tower B", buildingName: "Gedung Rektorat", units: 4 },
];

const unitsData = [
    { id: "1", unitNumber: "A101", floor: "Lantai 1", towerName: "Tower A", buildingName: "Gedung Rektorat" },
    { id: "2", unitNumber: "A102", floor: "Lantai 1", towerName: "Tower A", buildingName: "Gedung Rektorat" },
    { id: "3", unitNumber: "A103", floor: "Lantai 1", towerName: "Tower A", buildingName: "Gedung Rektorat" },
    { id: "4", unitNumber: "A104", floor: "Lantai 1", towerName: "Tower A", buildingName: "Gedung Rektorat" },
    { id: "5", unitNumber: "A201", floor: "Lantai 2", towerName: "Tower A", buildingName: "Gedung Rektorat" },
    { id: "6", unitNumber: "A202", floor: "Lantai 2", towerName: "Tower A", buildingName: "Gedung Rektorat" },
    { id: "7", unitNumber: "B101", floor: "Lantai 1", towerName: "Tower B", buildingName: "Gedung Rektorat" },
    { id: "8", unitNumber: "B102", floor: "Lantai 1", towerName: "Tower B", buildingName: "Gedung Rektorat" },
];

let currentFilterType = 'bangunan';

// Function to get filtered data based on current filter type and search query
function getFilteredData() {
    const searchQuery = document.getElementById('searchQuery').value.toLowerCase();
    
    switch (currentFilterType) {
        case 'bangunan':
            return buildingsData.filter(item =>
                item.name.toLowerCase().includes(searchQuery) ||
                item.address.toLowerCase().includes(searchQuery)
            );
        case 'tower':
            return towersData.filter(item =>
                item.towerName.toLowerCase().includes(searchQuery) ||
                item.buildingName.toLowerCase().includes(searchQuery)
            );
        case 'lantai':
            return floorsData.filter(item =>
                item.floorName.toLowerCase().includes(searchQuery) ||
                item.towerName.toLowerCase().includes(searchQuery) ||
                item.buildingName.toLowerCase().includes(searchQuery)
            );
        case 'unit':
            return unitsData.filter(item =>
                item.unitNumber.toLowerCase().includes(searchQuery) ||
                item.floor.toLowerCase().includes(searchQuery) ||
                item.towerName.toLowerCase().includes(searchQuery) ||
                item.buildingName.toLowerCase().includes(searchQuery)
            );
        default:
            return [];
    }
}

// Function to render table header based on filter type
function renderTableHeader() {
    const thead = document.querySelector('#dataTable thead');
    let headerHTML = '<tr>';
    
    switch (currentFilterType) {
        case 'bangunan':
            headerHTML += `
                <th class="px-4 py-3 text-start">Nama Bangunan</th>
                <th class="px-4 py-3 text-start">Alamat</th>
                <th class="px-4 py-3 text-start">Jumlah Tower</th>
                <th class="px-4 py-3 text-start">Jumlah Lantai</th>
                <th class="px-4 py-3 text-start">Jumlah Unit</th>
            `;
            break;
        case 'tower':
            headerHTML += `
                <th class="px-4 py-3 text-start">Nama Tower</th>
                <th class="px-4 py-3 text-start">Nama Rusun</th>
                <th class="px-4 py-3 text-start">Jumlah Lantai</th>
                <th class="px-4 py-3 text-start">Jumlah Unit</th>
            `;
            break;
        case 'lantai':
            headerHTML += `
                <th class="px-4 py-3 text-start">Nama Lantai</th>
                <th class="px-4 py-3 text-start">Nama Tower</th>
                <th class="px-4 py-3 text-start">Nama Rusun</th>
                <th class="px-4 py-3 text-start">Jumlah Unit</th>
            `;
            break;
        case 'unit':
            headerHTML += `
                <th class="px-4 py-3 text-start">Nomor Unit</th>
                <th class="px-4 py-3 text-start">Lantai</th>
                <th class="px-4 py-3 text-start">Nama Tower</th>
                <th class="px-4 py-3 text-start">Nama Rusun</th>
            `;
            break;
    }
    
    headerHTML += '</tr>';
    thead.innerHTML = headerHTML;
}

// Function to render table body based on filtered data
function renderTableBody() {
    const tbody = document.querySelector('#dataTable tbody');
    const filteredData = getFilteredData();
    
    if (filteredData.length === 0) {
        const colSpan = currentFilterType === 'bangunan' ? 5 : 4;
        tbody.innerHTML = `
            <tr>
                <td colspan="${colSpan}" class="px-4 py-4 text-center text-muted">
                    Tidak ada data yang ditemukan
                </td>
            </tr>
        `;
        return;
    }
    
    let bodyHTML = '';
    
    switch (currentFilterType) {
        case 'bangunan':
            filteredData.forEach(item => {
                bodyHTML += `
                    <tr class="hover-row">
                        <td class="px-4 py-3">${item.name}</td>
                        <td class="px-4 py-3 text-muted">${item.address}</td>
                        <td class="px-4 py-3 text-muted">${item.towers}</td>
                        <td class="px-4 py-3 text-muted">${item.floors}</td>
                        <td class="px-4 py-3 text-muted">${item.units}</td>
                    </tr>
                `;
            });
            break;
        case 'tower':
            filteredData.forEach(item => {
                bodyHTML += `
                    <tr class="hover-row">
                        <td class="px-4 py-3">${item.towerName}</td>
                        <td class="px-4 py-3 text-muted">${item.buildingName}</td>
                        <td class="px-4 py-3 text-muted">${item.floors}</td>
                        <td class="px-4 py-3 text-muted">${item.units}</td>
                    </tr>
                `;
            });
            break;
        case 'lantai':
            filteredData.forEach(item => {
                bodyHTML += `
                    <tr class="hover-row">
                        <td class="px-4 py-3">${item.floorName}</td>
                        <td class="px-4 py-3 text-muted">${item.towerName}</td>
                        <td class="px-4 py-3 text-muted">${item.buildingName}</td>
                        <td class="px-4 py-3 text-muted">${item.units}</td>
                    </tr>
                `;
            });
            break;
        case 'unit':
            filteredData.forEach(item => {
                bodyHTML += `
                    <tr class="hover-row">
                        <td class="px-4 py-3">${item.unitNumber}</td>
                        <td class="px-4 py-3 text-muted">${item.floor}</td>
                        <td class="px-4 py-3 text-muted">${item.towerName}</td>
                        <td class="px-4 py-3 text-muted">${item.buildingName}</td>
                    </tr>
                `;
            });
            break;
    }
    
    tbody.innerHTML = bodyHTML;
}

// Function to update the table based on current filter and search
function updateTable() {
    renderTableHeader();
    renderTableBody();
}

// Initialize the table when page loads
document.addEventListener('DOMContentLoaded', function() {
    updateTable();
    
    // Add event listeners
    document.getElementById('searchQuery').addEventListener('input', updateTable);
    document.getElementById('filterType').addEventListener('change', function(e) {
        currentFilterType = e.target.value;
        updateTable();
    });
});

// (APIunpar) Function to fetch data from Unpar API
async function fetchDataFromAPI() {
    try {
        // Example API calls - replace with actual Unpar API endpoints
        /*
        const buildingsResponse = await fetch('https://api.unpar.ac.id/buildings');
        const buildingsData = await buildingsResponse.json();
        
        const towersResponse = await fetch('https://api.unpar.ac.id/towers');
        const towersData = await towersResponse.json();
        
        const floorsResponse = await fetch('https://api.unpar.ac.id/floors');
        const floorsData = await floorsResponse.json();
        
        const unitsResponse = await fetch('https://api.unpar.ac.id/units');
        const unitsData = await unitsResponse.json();
        */
        
        // For now, we're using mock data
        console.log('Fetching data from API...');
    } catch (error) {
        console.error('Error fetching data from API:', error);
    }
}
</script>

<style>
.hover-row:hover {
    background-color: #f8f9fa !important;
    transition: background-color 0.2s ease;
}

.table th {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    border-bottom: 1px solid #e5e7eb;
}

.table td {
    font-size: 0.875rem;
    vertical-align: middle;
}

.card {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}
</style>
@endsection