<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminResourceController;
use App\Http\Controllers\AdminMaintenanceController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AccountRequestManagementController;
use App\Http\Controllers\Admin\ReservationManagementController;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'register'])->name('register');


// Route d'accueil publique
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard utilisateur
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


});

// ============================================
// TOUTES LES ROUTES ADMIN DANS UN SEUL GROUPE
// ============================================


    Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
    
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

    // GESTION DES UTILISATEURS
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::post('/users/{user}/toggle', [UserManagementController::class, 'toggleStatus'])->name('users.toggle');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    
    // GESTION DES DEMANDES DE COMPTE
    Route::get('/account-requests', [AccountRequestManagementController::class, 'index'])->name('account-requests.index');
    Route::get('/account-requests/{accountRequest}', [AccountRequestManagementController::class, 'show'])->name('account-requests.show');
    Route::post('/account-requests/{accountRequest}/approve', [AccountRequestManagementController::class, 'approve'])->name('account-requests.approve');
    Route::post('/account-requests/{accountRequest}/reject', [AccountRequestManagementController::class, 'reject'])->name('account-requests.reject');
    Route::delete('/account-requests/{accountRequest}', [AccountRequestManagementController::class, 'destroy'])->name('account-requests.destroy');


    // GESTION DES RÉSERVATIONS
    Route::get('/reservations', [ReservationManagementController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/status/{status}', [ReservationManagementController::class, 'filterByStatus'])->name('reservations.filter');
    Route::get('/reservations/{reservation}', [ReservationManagementController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{reservation}/approve', [ReservationManagementController::class, 'approve'])->name('reservations.approve');
    Route::post('/reservations/{reservation}/reject', [ReservationManagementController::class, 'reject'])->name('reservations.reject');
    Route::post('/reservations/{reservation}/terminate', [ReservationManagementController::class, 'terminate'])->name('reservations.terminate');
    Route::delete('/reservations/{reservation}', [ReservationManagementController::class, 'destroy'])->name('reservations.destroy');

});


    