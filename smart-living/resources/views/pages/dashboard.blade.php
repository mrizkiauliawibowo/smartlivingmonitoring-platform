@extends('layouts.app')

@section('title', 'Dashboard - Smart Building Monitoring')

@section('content')
    <div class="container-fluid" style="padding-top: 2rem;">
        <!-- Page Header -->
        <div class="mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- GIS Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">GIS Bangunan</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="bg-light h-96 w-full d-flex align-items-center justify-content-center">
                            <div class="text-center text-gray-500">
                                <i class="fas fa-map-marked-alt fa-4x mb-3 text-gray-400"></i>
                                <p class="text-gray-600 h5">Peta GIS Bangunan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <!-- Total Bangunan -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Bangunan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">24</div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-building text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penggunaan Listrik -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Penggunaan Listrik
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">5,800</div>
                                <div class="text-xs text-muted">kWh/bulan</div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-bolt text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penggunaan Air -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Penggunaan Air
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">1,690</div>
                                <div class="text-xs text-muted">m³/bulan</div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-info">
                                    <i class="fas fa-tint text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row - Vertical Layout -->
        <div class="row">
            <!-- Electricity Trend Chart - Full Width -->
            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tren Penggunaan Listrik</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-full">
                            <canvas id="electricityTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Water Trend Chart - Full Width -->
            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tren Penggunaan Air</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-full">
                            <canvas id="waterTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
/* Padding untuk kompensasi hilangnya topbar */
.container-fluid {
    padding-top: 2rem !important;
}

.h-96 {
    height: 24rem;
}

.icon-circle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
}

.chart-full {
    position: relative;
    height: 400px;
    width: 100%;
}

/* Memastikan chart responsive */
@media (max-width: 768px) {
    .chart-full {
        height: 300px;
    }
    
    /* Padding yang lebih kecil untuk mobile */
    .container-fluid {
        padding-top: 1.5rem !important;
    }
}

/* Menambahkan sedikit padding untuk tampilan yang lebih baik */
.card-body {
    padding: 1.5rem;
}

/* Optional: Tambahan spacing untuk header */
.mb-4 {
    margin-bottom: 1.5rem !important;
}
</style>
@endpush

@push('scripts')
<!-- Page level plugins -->
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

<script>
// Electricity Trend Data
const electricityData = [
    { month: "Jan", usage: 4500 },
    { month: "Feb", usage: 4800 },
    { month: "Mar", usage: 4200 },
    { month: "Apr", usage: 5100 },
    { month: "Mei", usage: 4900 },
    { month: "Jun", usage: 5300 },
    { month: "Jul", usage: 5600 },
    { month: "Agu", usage: 5200 },
    { month: "Sep", usage: 4800 },
    { month: "Okt", usage: 5400 },
    { month: "Nov", usage: 5100 },
    { month: "Des", usage: 5800 },
];

// Water Trend Data
const waterData = [
    { month: "Jan", usage: 1200 },
    { month: "Feb", usage: 1350 },
    { month: "Mar", usage: 1180 },
    { month: "Apr", usage: 1420 },
    { month: "Mei", usage: 1390 },
    { month: "Jun", usage: 1500 },
    { month: "Jul", usage: 1620 },
    { month: "Agu", usage: 1480 },
    { month: "Sep", usage: 1340 },
    { month: "Okt", usage: 1550 },
    { month: "Nov", usage: 1470 },
    { month: "Des", usage: 1690 },
];

// Electricity Trend Line Chart - Full Width
const electricityCtx = document.getElementById('electricityTrendChart');
new Chart(electricityCtx, {
    type: 'line',
    data: {
        labels: electricityData.map(d => d.month),
        datasets: [{
            label: 'Penggunaan Listrik (kWh)',
            data: electricityData.map(d => d.usage),
            borderColor: '#1cc88a',
            backgroundColor: 'rgba(28, 200, 138, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#1cc88a',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 8,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        size: 14
                    }
                }
            },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#6e707e',
                bodyColor: '#858796',
                borderColor: '#dddfeb',
                borderWidth: 1,
                padding: 15,
                cornerRadius: 8,
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        return `Penggunaan: ${context.parsed.y.toLocaleString()} kWh`;
                    }
                }
            }
        },
        scales: {
            x: {
                grid: {
                    color: 'rgba(221, 223, 235, 0.5)',
                    drawBorder: false,
                },
                ticks: {
                    color: '#858796',
                    font: {
                        size: 12
                    }
                }
            },
            y: {
                grid: {
                    color: 'rgba(221, 223, 235, 0.5)',
                    drawBorder: false,
                },
                ticks: {
                    color: '#858796',
                    font: {
                        size: 12
                    },
                    callback: function(value) {
                        return value.toLocaleString() + ' kWh';
                    }
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        }
    }
});

// Water Trend Bar Chart - Full Width
const waterCtx = document.getElementById('waterTrendChart');
new Chart(waterCtx, {
    type: 'bar',
    data: {
        labels: waterData.map(d => d.month),
        datasets: [{
            label: 'Penggunaan Air (m³)',
            data: waterData.map(d => d.usage),
            backgroundColor: '#36b9cc',
            borderColor: '#36b9cc',
            borderWidth: 0,
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        size: 14
                    }
                }
            },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#6e707e',
                bodyColor: '#858796',
                borderColor: '#dddfeb',
                borderWidth: 1,
                padding: 15,
                cornerRadius: 8,
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        return `Penggunaan: ${context.parsed.y.toLocaleString()} m³`;
                    }
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: false,
                    drawBorder: false,
                },
                ticks: {
                    color: '#858796',
                    font: {
                        size: 12
                    }
                }
            },
            y: {
                grid: {
                    color: 'rgba(221, 223, 235, 0.5)',
                    drawBorder: false,
                },
                ticks: {
                    color: '#858796',
                    font: {
                        size: 12
                    },
                    callback: function(value) {
                        return value.toLocaleString() + ' m³';
                    }
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        }
    }
});
</script>
@endpush