@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if($selectedBuilding)
                <!-- Detail View -->
                <div class="d-flex flex-column h-100 overflow-auto">
                    <div class="p-3 p-md-4">
                        <!-- Back Button -->
                        <button type="button" class="btn btn-outline-secondary mb-3" onclick="window.history.back()">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </button>

                        <!-- Page Header -->
                        <div class="mb-4">
                            <h1 class="h3 mb-2 text-dark">Data Utilitas</h1>
                            <p class="text-muted">{{ $building->name ?? '(apiunpar)' }}</p>
                        </div>

                        <!-- Statistics Cards -->
                        <div class="row mb-4">
                            <!-- Penggunaan Listrik -->
                            <div class="col-md-6 mb-3">
                                <div class="card border-start border-teal border-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="card-text text-muted small mb-1">Penggunaan Listrik</p>
                                                <h4 class="card-title text-dark">2,900</h4>
                                                <p class="card-text text-muted small">kWh/bulan</p>
                                            </div>
                                            <div class="rounded-circle bg-teal-100 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                <i class="fas fa-bolt text-teal"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Penggunaan Air -->
                            <div class="col-md-6 mb-3">
                                <div class="card border-start border-cyan border-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="card-text text-muted small mb-1">Penggunaan Air</p>
                                                <h4 class="card-title text-dark">810</h4>
                                                <p class="card-text text-muted small">m³/bulan</p>
                                            </div>
                                            <div class="rounded-circle bg-cyan-100 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                <i class="fas fa-tint text-cyan"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Electricity Trend Chart -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-dark mb-3">Tren Penggunaan Listrik</h5>
                                <div style="height: 320px;">
                                    <canvas id="electricityChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Water Trend Chart -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-dark mb-3">Tren Penggunaan Air</h5>
                                <div style="height: 320px;">
                                    <canvas id="waterChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- List View -->
                <div class="d-flex flex-column h-100 overflow-auto">
                    <div class="p-3 p-md-4">
                        <!-- Page Header -->
                        <div class="mb-4">
                            <h1 class="h3 mb-3 text-dark">Monitoring Utilitas</h1>

                            <!-- Search Box -->
                            <div class="position-relative max-w-md">
                                
                                <input 
                                    type="text" 
                                    class="form-control ps-5" 
                                    placeholder="Cari bangunan..."
                                    id="searchQuery"
                                    value="{{ request('search') }}"
                                >
                            </div>
                        </div>

                        <!-- Building Table -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0 text-dark">Daftar Bangunan</h5>
                                <p class="text-muted small mt-1">Total: {{ count($buildings) }}</p>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="px-4 py-2 text-start">Nama Bangunan</th>
                                            <th class="px-4 py-2 text-start">Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($buildings) > 0)
                                            @foreach($buildings as $building)
                                                <tr 
                                                    class="cursor-pointer" 
                                                    onclick="window.location.href='{{ route('utilitiesmonitoring.detail', ['id' => $building->id]) }}'"
                                                    style="cursor: pointer;"
                                                >
                                                    <td class="px-4 py-3">{{ $building->name }}</td>
                                                    <td class="px-4 py-3 text-muted">{{ $building->address }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2" class="px-4 py-4 text-center text-muted">
                                                    Tidak ada data yang ditemukan
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Electricity Chart
const electricityCtx = document.getElementById('electricityChart').getContext('2d');
const electricityChart = new Chart(electricityCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
            label: 'kWh',
            data: [2300, 2450, 2100, 2600, 2500, 2700, 2850, 2650, 2400, 2750, 2600, 2900],
            borderColor: '#14b8a6',
            backgroundColor: 'rgba(20, 184, 166, 0.1)',
            borderWidth: 2,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(229, 231, 235, 1)'
                }
            },
            x: {
                grid: {
                    color: 'rgba(229, 231, 235, 1)'
                }
            }
        },
        plugins: {
            legend: {
                display: true
            }
        }
    }
});

// Water Chart
const waterCtx = document.getElementById('waterChart').getContext('2d');
const waterChart = new Chart(waterCtx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
            label: 'm³',
            data: [580, 620, 560, 680, 650, 720, 780, 710, 630, 740, 700, 810],
            backgroundColor: '#06b6d4',
            borderColor: '#06b6d4',
            borderWidth: 0,
            borderRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(229, 231, 235, 1)'
                }
            },
            x: {
                grid: {
                    color: 'rgba(229, 231, 235, 1)'
                }
            }
        },
        plugins: {
            legend: {
                display: true
            }
        }
    }
});

// Search functionality
document.getElementById('searchQuery').addEventListener('input', function(e) {
    const searchValue = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const buildingName = row.cells[0].textContent.toLowerCase();
        const address = row.cells[1].textContent.toLowerCase();
        
        if (buildingName.includes(searchValue) || address.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<style>
.border-teal {
    border-color: #14b8a6 !important;
}
.border-cyan {
    border-color: #06b6d4 !important;
}
.bg-teal-100 {
    background-color: rgba(20, 184, 166, 0.1);
}
.text-teal {
    color: #14b8a6;
}
.bg-cyan-100 {
    background-color: rgba(6, 182, 212, 0.1);
}
.text-cyan {
    color: #06b6d4;
}
.max-w-md {
    max-width: 28rem;
}
.cursor-pointer {
    cursor: pointer;
}
</style>
@endsection