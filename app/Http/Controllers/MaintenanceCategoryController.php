<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaintenanceCategoryRequest;
use App\Http\Requests\UpdateMaintenanceCategoryRequest;
use App\Models\MaintenanceCategory;
use Inertia\Inertia;

class MaintenanceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('MaintenanceCategories/Index', ['items'=>MaintenanceCategory::all()]);
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
    public function store(StoreMaintenanceCategoryRequest $request)
    {
        return MaintenanceCategory::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceCategory $maintenancecategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceCategory $maintenancecategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaintenanceCategoryRequest $request, MaintenanceCategory $maintenancecategory)
    {
        $maintenancecategory->update($request->all());
        return $maintenancecategory->refresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceCategory $maintenancecategory)
    {
        //
    }
}
