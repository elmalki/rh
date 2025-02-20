<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarTypeRequest;
use App\Http\Requests\UpdateCarTypeRequest;
use App\Models\CarType;
use Inertia\Inertia;

class CarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('CarTypes/Index', ['items' => CarType::all()]);
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
    public function store(StoreCarTypeRequest $request)
    {
        return CarType::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(CarType $carType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarType $carType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarTypeRequest $request, CarType $cartype)
    {
        $cartype->update($request->all());
        return $cartype->refresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarType $carType)
    {
        //
    }
}
