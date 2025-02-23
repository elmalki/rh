<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('fuels', \App\Http\Controllers\FuelController::class);
    Route::resource('destinations', \App\Http\Controllers\DestinationController::class);
    Route::resource('cartypes', \App\Http\Controllers\CarTypeController::class);
    Route::resource('papers', \App\Http\Controllers\PaperController::class);
    Route::resource('maintenancetypes', \App\Http\Controllers\MaintenanceTypeController::class);
    Route::resource('leavetypes', \App\Http\Controllers\LeaveTypeController::class);
    Route::resource('carbrands', \App\Http\Controllers\CarBrandController::class);
    Route::resource('cars', \App\Http\Controllers\CarController::class);
    Route::resource('departments', \App\Http\Controllers\DepartmentController::class);
    Route::resource('maintenances', \App\Http\Controllers\MaintenanceController::class);
    Route::resource('personnels', \App\Http\Controllers\PersonnelController::class);
    Route::resource('budgets', \App\Http\Controllers\BudgetController::class);
    Route::resource('dotations', \App\Http\Controllers\DotationController::class);
    Route::resource('missions', \App\Http\Controllers\MissionController::class);
});
