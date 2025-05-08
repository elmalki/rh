<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarBrandRequest;
use App\Http\Requests\UpdateCarBrandRequest;
use App\Models\CarBrand;
use Inertia\Inertia;

class CarBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('CarBrands/Index', ['items' => CarBrand::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarBrandRequest $request)
    {
        return CarBrand::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(CarBrand $carbrand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarBrand $carbrand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarBrandRequest $request, CarBrand $carbrand)
    {
        $carbrand->update($request->all());
        return $carbrand->refresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarBrand $carbrand)
    {
        //$carbrand->delete();
        return redirect()->route('carbrands.index')->banner('mission updated successfully');
    }
}
