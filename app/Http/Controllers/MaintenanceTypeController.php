<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaintenanceTypeRequest;
use App\Http\Requests\UpdateMaintenanceTypeRequest;
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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaintenanceTypeRequest $request)
    {
        return MaintenanceType::create($request->all());
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaintenanceTypeRequest $request, MaintenanceType $maintenancetype)
    {
        $maintenancetype->update($request->all());
        return $maintenancetype->refresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceType $maintenancetype)
    {
        //
    }
}
