<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDotationRequest;
use App\Http\Requests\UpdateDotationRequest;
use App\Models\Budget;
use App\Models\Car;
use App\Models\Dotation;
use App\Models\MonthlyReport;
use App\Models\Personnel;
use Inertia\Inertia;

class DotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Dotations/Index', ['items'=>Dotation::orderBy('id','desc')->paginate(10),'sort_fields'=>request()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dotations/Create',['budget'=>Budget::all()->sum('remaining'),'cars'=>Car::with('maintenance_types')->get(),'personnels'=>Personnel::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDotationRequest $request)
    {
        $dotation = Dotation::create($request->all());
        $budget = Budget::first();
        MonthlyReport::create(['car_id' => $request->car_id, 'dotation_id' => $dotation->id, 'date' => $dotation->created_at]);
        $budget->update(['remaining'=>$budget->remaining-$request->value]);
        Car::find($request->car_id)->update(['kilometrage' => $request->km]);
       return redirect()->route('dotations.index')->banner('Dotation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dotation $dotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dotation $dotation)
    {
        return Inertia::render('Dotations/Edit',['budget'=>Budget::all()->sum('remaining'),'dotation'=>$dotation,'cars'=>Car::with('maintenance_types')->get(),'personnels'=>Personnel::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDotationRequest $request, Dotation $dotation)
    {
        $dotation->update($request->all());
        $monthlyReport = MonthlyReport::where('dotation_id', $dotation->id)->get()->first();
        $monthlyReport->update(['car_id' => $request->car_id]);
        Car::find($request->car_id)->update(['kilometrage'=>$request->km]);
        return redirect()->route('dotations.index')->banner('Dotation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dotation $dotation)
    {
        //
    }
}
