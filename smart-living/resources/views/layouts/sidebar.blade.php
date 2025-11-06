<!-- Sidebar -->
<div class="hidden md:flex h-screen bg-white border-r border-gray-200 flex-col" 
     style="width: 300px;">
<!-- Logo/Title -->
<div class="px- py-4 border-b border-gray-200">
    <div class="d-flex align-items-center gap-4">
        <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-blue-500 rounded-lg d-flex align-items-center justify-content-center">
            <i class="fas fa-desktop text-white" style="font-size: 1.5rem;"></i>
        </div>
        <div class="flex-grow-1">
            <h1 class="text-gray-900 mb-1" style="font-size: 1.1rem; font-weight: 700;">Smart Building</h1>
            <p class="text-gray-500 mb-0" style="font-size: 0.85rem;">Monitor</p>
        </div>
    </div>
</div>

    <!-- Navigation Menu -->
    <nav class="flex-1 p-4" style="flex: 1; padding: 1rem;">
        <!-- Dashboard -->
        <a href="{{ url('/dashboard') }}" 
           class="d-flex align-items-center gap-3 w-100 px-3 py-3 rounded text-decoration-none mb-2 {{ request()->is('/') || request()->is('dashboard') ? 'bg-teal-50 text-teal-700 border border-teal-100' : 'text-gray-600 hover-bg-gray-50' }}"
           style="gap: 0.75rem; padding: 0.75rem; border-radius: 0.5rem; text-decoration: none; margin-bottom: 0.5rem; transition: all 0.2s;">
            <i class="fas fa-tachometer-alt" style="width: 1.25rem; height: 1.25rem;"></i>
            <span style="font-weight: 500;">Dashboard</span>
        </a>

        <!-- Monitoring Utilitas -->
        <a href="{{ url('/utilitiesmonitoring') }}" 
           class="d-flex align-items-center gap-3 w-100 px-3 py-3 rounded text-decoration-none mb-2 {{ request()->is('utilitiesmonitoring') || request()->is('utilitiesonitoring*') ? 'bg-teal-50 text-teal-700 border border-teal-100' : 'text-gray-600 hover-bg-gray-50' }}"
           style="gap: 0.75rem; padding: 0.75rem; border-radius: 0.5rem; text-decoration: none; margin-bottom: 0.5rem; transition: all 0.2s;">
            <i class="fas fa-chart-line" style="width: 1.25rem; height: 1.25rem;"></i>
            <span style="font-weight: 500;">Monitoring Utilitas</span>
        </a>

        <!-- Data Bangunan -->
        <a href="{{ url('/buildingdata') }}" 
           class="d-flex align-items-center gap-3 w-100 px-3 py-3 rounded text-decoration-none mb-2 {{ request()->is('buildingdata') || request()->is('data-bangunan*') ? 'bg-teal-50 text-teal-700 border border-teal-100' : 'text-gray-600 hover-bg-gray-50' }}"
           style="gap: 0.75rem; padding: 0.75rem; border-radius: 0.5rem; text-decoration: none; margin-bottom: 0.5rem; transition: all 0.2s;">
            <i class="fas fa-building" style="width: 1.25rem; height: 1.25rem;"></i>
            <span style="font-weight: 500;">Data Bangunan</span>
        </a>

        <!-- Manajemen Data -->
        <a href="{{ url('/data-management') }}" 
           class="d-flex align-items-center gap-3 w-100 px-3 py-3 rounded text-decoration-none mb-2 {{ request()->is('data-management') || request()->is('manajemen*') ? 'bg-teal-50 text-teal-700 border border-teal-100' : 'text-gray-600 hover-bg-gray-50' }}"
           style="gap: 0.75rem; padding: 0.75rem; border-radius: 0.5rem; text-decoration: none; margin-bottom: 0.5rem; transition: all 0.2s;">
            <i class="fas fa-database" style="width: 1.25rem; height: 1.25rem;"></i>
            <span style="font-weight: 500;">Manajemen Data</span>
        </a>

        <!-- Profil -->
        <a href="{{ url('/profile') }}" 
           class="d-flex align-items-center gap-3 w-100 px-3 py-3 rounded text-decoration-none mb-2 {{ request()->is('profile') || request()->is('profil*') ? 'bg-teal-50 text-teal-700 border border-teal-100' : 'text-gray-600 hover-bg-gray-50' }}"
           style="gap: 0.75rem; padding: 0.75rem; border-radius: 0.5rem; text-decoration: none; margin-bottom: 0.5rem; transition: all 0.2s;">
            <i class="fas fa-user" style="width: 1.25rem; height: 1.25rem;"></i>
            <span style="font-weight: 500;">Profil</span>
        </a>
    </nav>
</div>