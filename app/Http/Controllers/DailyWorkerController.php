<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDailyWorkerRequest;
use App\Http\Requests\UpdateDailyWorkerRequest;
use App\Models\DailyWorker;
use Inertia\Inertia;

class DailyWorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('DailyWorkers/Index', ['items'=>DailyWorker::paginate(10),'sort_fields'=>request()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('DailyWorkers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDailyWorkerRequest $request)
    {
        DailyWorker::create($request->all());
        return redirect()->route('dailyworkers.index')->banner('Ouvriers ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyWorker $dailyworker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyWorker $dailyworker)
    {
        return Inertia::render('DailyWorkers/Edit',['dailyworker'=>$dailyworker]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDailyWorkerRequest $request, DailyWorker $dailyworker)
    {
        $dailyworker->update($request->all());
        return redirect()->route('dailyworkers.index')->banner('Ouvriers modifié avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyWorker $dailyworker)
    {
        //
    }
}
