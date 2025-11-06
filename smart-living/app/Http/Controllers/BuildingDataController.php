<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BuildingDataController
{
    public function index(Request $request)
    {
        $searchQuery = $request->query('search', '');
        $filterType = $request->query('filter', 'bangunan');
        
        // (APIunpar) - Ambil data dari API Unpar berdasarkan filter type
        $data = $this->getDataFromAPI($filterType, $searchQuery);
        
        return view('pages.buildingdata', [
            'searchQuery' => $searchQuery,
            'filterType' => $filterType,
            'data' => $data
        ]);
    }
    
    private function getDataFromAPI($filterType, $searchQuery = '')
    {
        // (APIunpar) - Implementasi pengambilan data dari API Unpar
        // Contoh implementasi dengan HTTP client
        /*
        $endpoint = '';
        
        switch ($filterType) {
            case 'bangunan':
                $endpoint = 'https://api.unpar.ac.id/buildings';
                break;
            case 'tower':
                $endpoint = 'https://api.unpar.ac.id/towers';
                break;
            case 'lantai':
                $endpoint = 'https://api.unpar.ac.id/floors';
                break;
            case 'unit':
                $endpoint = 'https://api.unpar.ac.id/units';
                break;
        }
        
        $response = Http::get($endpoint, [
            'search' => $searchQuery
        ]);
        
        if ($response->successful()) {
            return $response->json();
        }
        */
        
        // Data mock sementara berdasarkan filter type
        switch ($filterType) {
            case 'bangunan':
                return [
                    ['id' => '1', 'name' => 'Gedung Rektorat', 'address' => 'Jl. Telekomunikasi No. 1, Bandung', 'towers' => 2, 'floors' => 8, 'units' => 64],
                    ['id' => '2', 'name' => 'Gedung Perpustakaan', 'address' => 'Jl. Telekomunikasi No. 2, Bandung', 'towers' => 1, 'floors' => 5, 'units' => 30],
                    // ... data lainnya
                ];
            case 'tower':
                return [
                    ['id' => '1', 'towerName' => 'Tower A', 'buildingName' => 'Gedung Rektorat', 'floors' => 8, 'units' => 32],
                    ['id' => '2', 'towerName' => 'Tower B', 'buildingName' => 'Gedung Rektorat', 'floors' => 8, 'units' => 32],
                    // ... data lainnya
                ];
            case 'lantai':
                return [
                    ['id' => '1', 'floorName' => 'Lantai 1', 'towerName' => 'Tower A', 'buildingName' => 'Gedung Rektorat', 'units' => 4],
                    ['id' => '2', 'floorName' => 'Lantai 2', 'towerName' => 'Tower A', 'buildingName' => 'Gedung Rektorat', 'units' => 4],
                    // ... data lainnya
                ];
            case 'unit':
                return [
                    ['id' => '1', 'unitNumber' => 'A101', 'floor' => 'Lantai 1', 'towerName' => 'Tower A', 'buildingName' => 'Gedung Rektorat'],
                    ['id' => '2', 'unitNumber' => 'A102', 'floor' => 'Lantai 1', 'towerName' => 'Tower A', 'buildingName' => 'Gedung Rektorat'],
                    // ... data lainnya
                ];
            default:
                return [];
        }
    }
}