<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminResourceController;
use App\Http\Controllers\AdminMaintenanceController;

// Redirection vers dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// ============================================
// TOUTES LES ROUTES ADMIN DANS UN SEUL GROUPE
// ============================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // DASHBOARD - DÉPLACÉ ICI
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'totalUsers' => \App\Models\User::count(),
            'totalResources' => \App\Models\Resource::count(),
            'totalCategories' => \App\Models\ResourceCategory::count(),
        ]);
    })->name('dashboard');  // nom: 'admin.dashboard'
    
    // RESSOURCES
    Route::get('/resources', [AdminResourceController::class, 'index'])->name('resources.index');
    Route::get('/resources/create', [AdminResourceController::class, 'create'])->name('resources.create');
    Route::post('/resources', [AdminResourceController::class, 'store'])->name('resources.store');
    Route::get('/resources/{resource}/edit', [AdminResourceController::class, 'edit'])->name('resources.edit');
    Route::put('/resources/{resource}', [AdminResourceController::class, 'update'])->name('resources.update');
    Route::post('/resources/{resource}/toggle', [AdminResourceController::class, 'toggleStatus'])->name('resources.toggle');
    Route::post('/resources/{resource}/update-status', [AdminResourceController::class, 'updateStatus'])->name('resources.updateStatus');
    
    // MAINTENANCES
    Route::get('/maintenances', [AdminMaintenanceController::class, 'index'])->name('maintenances.index');
    Route::get('/maintenances/create', [AdminMaintenanceController::class, 'create'])->name('maintenances.create');
    Route::post('/maintenances', [AdminMaintenanceController::class, 'store'])->name('maintenances.store');
    Route::get('/maintenances/{maintenance}/edit', [AdminMaintenanceController::class, 'edit'])->name('maintenances.edit');
    Route::put('/maintenances/{maintenance}', [AdminMaintenanceController::class, 'update'])->name('maintenances.update');
    Route::delete('/maintenances/{maintenance}', [AdminMaintenanceController::class, 'destroy'])->name('maintenances.destroy');
});