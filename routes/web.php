<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminResourceController;
use App\Http\Controllers\AdminMaintenanceController;

Route::get('/', function () {
    return view('welcome');
});

// Route pour voir la LISTE des ressources
Route::get('/admin/resources', [AdminResourceController::class, 'index'])
    ->name('admin.resources.index');

// Route pour AFFICHER le formulaire d'ajout
Route::get('/admin/resources/create', [AdminResourceController::class, 'create'])
    ->name('admin.resources.create');

// Route pour SAUVEGARDER une nouvelle ressource
Route::post('/admin/resources', [AdminResourceController::class, 'store'])
    ->name('admin.resources.store');

// Route pour AFFICHER le formulaire de modification
Route::get('/admin/resources/{resource}/edit', [AdminResourceController::class, 'edit'])
    ->name('admin.resources.edit');

// Route pour SAUVEGARDER les modifications
Route::put('/admin/resources/{resource}', [AdminResourceController::class, 'update'])
    ->name('admin.resources.update');

// Route pour changer le status (Activer/Désactiver)
Route::post('/admin/resources/{resource}/toggle', [AdminResourceController::class, 'toggleStatus'])
    ->name('admin.resources.toggle');

// Routes pour la Maintenance
Route::get('/admin/maintenances', [AdminMaintenanceController::class, 'index'])->name('admin.maintenances.index');
Route::get('/admin/maintenances/create', [AdminMaintenanceController::class, 'create'])->name('admin.maintenances.create');
Route::post('/admin/maintenances', [AdminMaintenanceController::class, 'store'])->name('admin.maintenances.store');