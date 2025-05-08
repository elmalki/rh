<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaintenanceTypeRequest;
use App\Http\Requests\UpdateMaintenanceTypeRequest;
use App\Models\MaintenanceCategory;
use App\Models\MaintenanceType;
use Inertia\Inertia;

class MaintenanceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('MaintenanceTypes/Index', ['items'=>MaintenanceType::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('MaintenanceTypes/Create',['categories'=>MaintenanceCategory::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaintenanceTypeRequest $request)
    {
         MaintenanceType::create($request->all());
        return  redirect()->route('maintenancetypes.index')->banner('Type ajouté avec succés.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceType $maintenancetype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceType $maintenancetype)
    {
        return Inertia::render('MaintenanceTypes/Edit',['item'=>$maintenancetype,'categories'=>MaintenanceCategory::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaintenanceTypeRequest $request, MaintenanceType $maintenancetype)
    {
        $maintenancetype->update($request->all());
        return redirect()->route('maintenancetypes.index')->banner('Type modifier avec succés.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceType $maintenancetype)
    {
        $maintenancetype->delete();
        return  redirect()->route('maintenancetypes.index')->dangerBanner('Type supprimer avec succés.');
    }
}
