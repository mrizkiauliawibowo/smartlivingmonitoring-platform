<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\BuildingDataController;

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});

Route::get('/utilitiesmonitoring', [UtilityController::class, 'index'])->name('utilitiesmonitoring');
Route::get('/utilitiesmonitoring/{id}', [UtilityController::class, 'show'])->name('utilitiesmonitoring.detail');
Route::get('/buildingdata', [BuildingDataController::class, 'index'])->name('buildingdata');