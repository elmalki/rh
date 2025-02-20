<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Requests\UpdateMaintenanceRequest;
use App\Models\Car;
use App\Models\Maintenance;
use App\Models\MaintenanceType;
use Inertia\Inertia;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Maintenances/Index', ['items' => Maintenance::paginate(10),'sort_fields'=>request()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Maintenances/Create',['cars'=>Car::all(),'maintenance_types'=>MaintenanceType::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaintenanceRequest $request)
    {
        Maintenance::create( $request->all() );
        return redirect()->route('maintenances.index')->banner('Maintenance a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        return Inertia::render('Maintenances/Edit',['maintenance'=>$maintenance,'cars'=>Car::all(),'maintenance_types'=>MaintenanceType::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaintenanceRequest $request, Maintenance $maintenance)
    {
        $maintenance->update( $request->all() );
        return  redirect()->route('maintenances.index')->banner('Maintenance a été modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        //
    }
}
