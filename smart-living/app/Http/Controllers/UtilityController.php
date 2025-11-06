<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UtilityController
{
    public function index(Request $request)
    {
        $searchQuery = $request->query('search', '');
        
        // (apiunpar) - Ambil data bangunan dari API Unpar
        $buildings = $this->getBuildingsFromAPI($searchQuery);
        
        return view('pages.utilitiesmonitoring', [
            'selectedBuilding' => null,
            'buildings' => $buildings,
            'searchQuery' => $searchQuery
        ]);
    }
    
    public function show($id)
    {
        // (apiunpar) - Ambil data bangunan spesifik dari API Unpar
        $building = $this->getBuildingDetailFromAPI($id);
        
        // (apiunpar) - Ambil data listrik dari API Unpar
        $electricityData = $this->getElectricityDataFromAPI($id);
        
        // (apiunpar) - Ambil data air dari API Unpar
        $waterData = $this->getWaterDataFromAPI($id);
        
        return view('pages.utilitiesmonitoring', [
            'selectedBuilding' => $id,
            'building' => $building,
            'electricityData' => $electricityData,
            'waterData' => $waterData
        ]);
    }
    
    private function getBuildingsFromAPI($searchQuery = '')
    {
        // (apiunpar) - Implementasi pengambilan data dari API Unpar
        // Contoh implementasi dengan HTTP client
        /*
        $response = Http::get('https://api.unpar.ac.id/buildings', [
            'search' => $searchQuery
        ]);
        
        if ($response->successful()) {
            return $response->json();
        }
        */
        
        // Data mock sementara
        return [
            (object)['id' => '1', 'name' => 'Gedung Rektorat', 'address' => 'Jl. Telekomunikasi No. 1, Bandung'],
            (object)['id' => '2', 'name' => 'Gedung Perpustakaan', 'address' => 'Jl. Telekomunikasi No. 2, Bandung'],
            (object)['id' => '3', 'name' => 'Gedung Fakultas Teknik', 'address' => 'Jl. Telekomunikasi No. 3, Bandung'],
            // ... data lainnya
        ];
    }
    
    private function getBuildingDetailFromAPI($id)
    {
        // (apiunpar) - Implementasi pengambilan detail bangunan dari API Unpar
        /*
        $response = Http::get("https://api.unpar.ac.id/buildings/{$id}");
        
        if ($response->successful()) {
            return $response->json();
        }
        */
        
        // Data mock sementara
        return (object)[
            'id' => $id,
            'name' => 'Gedung Rektorat',
            'address' => 'Jl. Telekomunikasi No. 1, Bandung'
        ];
    }
    
    private function getElectricityDataFromAPI($id)
    {
        // (apiunpar) - Implementasi pengambilan data listrik dari API Unpar
        // Return data dalam format yang sesuai untuk chart
    }
    
    private function getWaterDataFromAPI($id)
    {
        // (apiunpar) - Implementasi pengambilan data air dari API Unpar
        // Return data dalam format yang sesuai untuk chart
    }
}