<?php

use App\Http\Controllers\ReportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/ordre-de-mission/{mission}',[\App\Http\Controllers\MissionController::class,'orderDeMission'])->name('missions.ordre-de-mission');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/',\App\Http\Controllers\HomeController::class)->name('dashboard');
    Route::get('carnetDeBord', [\App\Http\Controllers\DeplacementController::class, 'carnetDeBord'])->name('deplacements.carnetDeBord');
    Route::post('carnetDeBordReport', [\App\Http\Controllers\DeplacementController::class, 'carnetDeBordReport'])->name('deplacements.carnetDeBordReport');
    Route::get('etat-mensuelle', [ReportController::class, 'chooseMonth'])->name('maintenances.etatmensuelle');
    Route::post('monthlyReport', [ReportController::class, 'monthlyReport'])->name('monthlyReport');
    Route::resource('deplacements', \App\Http\Controllers\DeplacementController::class);
    Route::resource('settings', \App\Http\Controllers\SettingController::class)->only(['index', 'edit', 'update']);
    Route::resource('fuels', \App\Http\Controllers\FuelController::class);
    Route::resource('destinations', \App\Http\Controllers\DestinationController::class);
    Route::resource('cartypes', \App\Http\Controllers\CarTypeController::class);
    Route::resource('papers', \App\Http\Controllers\PaperController::class);
    Route::resource('maintenancetypes', \App\Http\Controllers\MaintenanceTypeController::class);
    Route::resource('maintenancecategories', \App\Http\Controllers\MaintenanceCategoryController::class);
    Route::resource('leavetypes', \App\Http\Controllers\LeaveTypeController::class);
    Route::resource('carbrands', \App\Http\Controllers\CarBrandController::class);
    Route::resource('cars', \App\Http\Controllers\CarController::class);
    Route::resource('departments', \App\Http\Controllers\DepartmentController::class);
    Route::resource('maintenances', \App\Http\Controllers\MaintenanceController::class);
    Route::resource('personnels', \App\Http\Controllers\PersonnelController::class);
    Route::resource('budgets', \App\Http\Controllers\BudgetController::class);
    Route::resource('dotations', \App\Http\Controllers\DotationController::class);
    Route::resource('missions', \App\Http\Controllers\MissionController::class);
    Route::resource('leaves', \App\Http\Controllers\LeaveController::class)->parameter('leaves','leave');
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\PermissionController::class);
    Route::get('etat-par-type',[\App\Http\Controllers\MaintenanceController::class,'etat'])->name('maintenances.etat');
    Route::post('etat',[\App\Http\Controllers\MaintenanceController::class,'getEtat'])->name('maintenances.getEtat');
    Route::post('etatPdf',[\App\Http\Controllers\MaintenanceController::class,'getEtatPdf'])->name('maintenances.getEtatPdf');

    //calendars
    Route::get('missions-calendar',function (){
        return Inertia::render('Missions/Calendar');
    })->name('missions.show_calendar');
    Route::post('missions-calendar',[\App\Http\Controllers\MissionController::class,'calendar'])->name('missions.calendar');
    Route::get('leaves-calendar',function (){
        return Inertia::render('Leaves/Calendar');
    })->name('leaves.show_calendar');
    Route::post('leaves-calendar',[\App\Http\Controllers\LeaveController::class,'calendar'])->name('leaves.calendar');
});
