<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminResourceController;     // Controller dyal l-bent
use App\Http\Controllers\AdminMaintenanceController;  // Controller dyal Maintenance

// 1. Redirection: Mli dkhl l site (localhost:8000), ydikk direct l Dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// 2. Route DASHBOARD (Version Simple w Madmona)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard', [
        'totalUsers' => \App\Models\User::count(),
        'totalResources' => \Illuminate\Support\Facades\DB::table('resources')->count(),
        'totalCategories' => \Illuminate\Support\Facades\DB::table('resource_categories')->count(),
    ]);
})->name('admin.dashboard');

// 3. Routes RESSOURCES & MAINTENANCE (Mjoum3in taht /admin)
Route::prefix('admin')->name('admin.')->group(function () {
    
    // --- RESSOURCES ---
    Route::get('/resources', [AdminResourceController::class, 'index'])->name('resources.index');
    Route::get('/resources/create', [AdminResourceController::class, 'create'])->name('resources.create');
    Route::post('/resources', [AdminResourceController::class, 'store'])->name('resources.store');
    Route::get('/resources/{resource}/edit', [AdminResourceController::class, 'edit'])->name('resources.edit');
    Route::put('/resources/{resource}', [AdminResourceController::class, 'update'])->name('resources.update');
    
    // 👇 HADI HIYA LI BDDLNA (Kan smitha toggle, rddinaha update-status)
    Route::post('/resources/{resource}/update-status', [AdminResourceController::class, 'updateStatus'])->name('resources.updateStatus');
    // --- MAINTENANCES ---
    Route::get('/maintenances', [AdminMaintenanceController::class, 'index'])->name('maintenances.index');
    Route::get('/maintenances/create', [AdminMaintenanceController::class, 'create'])->name('maintenances.create');
    Route::post('/maintenances', [AdminMaintenanceController::class, 'store'])->name('maintenances.store');
});