<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeplacementRequest;
use App\Http\Requests\UpdateDeplacementRequest;
use App\Models\Car;
use App\Models\Deplacement;
use App\Models\Personnel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CarnetDeBordExcel;

class DeplacementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Deplacements/Index', ['items' => Deplacement::with(['car','personnel'])->paginate(10),'sort_fields'=>request()->all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Deplacements/Create',['cars'=>Car::all(),'personnels'=>Personnel::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeplacementRequest $request)
    {
        Deplacement::create($request->all());
        Car::find($request->car_id)->update(['kilometrage'=>$request->km_arrivee]);
        return redirect()->route('deplacements.index')->banner('Déplacement ajouter avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Deplacement $deplacement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deplacement $deplacement)
    {
        return Inertia::render('Deplacements/Edit',['deplacement'=>$deplacement,'cars'=>Car::all(),'personnels'=>Personnel::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeplacementRequest $request, Deplacement $deplacement)
    {
        $deplacement->update($request->all());
        $deplacement->car->update(['kilometrage'=>$request->km_arrivee]);
        return redirect()->route('deplacements.index')->banner('Déplacement Modifier avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deplacement $deplacement)
    {
        //
    }
    public function carnetDeBord()
    {
        return Inertia::render('Deplacements/CarnetBord',['cars'=>Car::all()]);
    }
    public function carnetDeBordReport(Request $request){
        return Excel::download(new CarnetDeBordExcel(request()->json()->all()),'invoice.xlsx');
    }
}
