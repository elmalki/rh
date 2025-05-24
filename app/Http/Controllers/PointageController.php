<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePointageRequest;
use App\Http\Requests\UpdatePointageRequest;
use App\Models\Pointage;
use App\Models\DailyWorker;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PointageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dates = Pointage::select('date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->paginate(10);

// Transformer les items de la collection paginée
        $transformedItems = $dates->getCollection()->map(function ($dateItem) {
            $workers = \App\Models\Pointage::with('worker')
                ->whereDate('date', $dateItem->date)
                ->get(['daily_worker_id', 'wage', 'date','id']);

            return [
                'date' => $dateItem->date,
                'workers' => $workers
            ];
        });

// Réassigner la collection transformée à l'objet paginé
        $dates->setCollection($transformedItems);

// Retourner la pagination corrigée à Inertia
        return Inertia::render('Pointages/Index', [
            'items' => $dates,
            'sort_fields' => request()
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Pointages/Create',['wage'=>Pointage::latest()->first()->wage,'workers'=>DailyWorker::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePointageRequest $request)
    {
        $date =  Carbon::parse($request->date)->addHour()->format('Y-m-d');
        foreach ($request->workers as $dailyworker) {
            $old = Pointage::where('date',$date)->where('daily_worker_id',$dailyworker['id'])->first();
            if($old){
                $old->update(['wage'=>$request->wage]);
                continue;
            }
            Pointage::create(['daily_worker_id'=>$dailyworker['id'],'date'=>$date,'wage'=>$request->wage]);
        }
        return redirect()->route('pointages.index')->banner( 'Pointages crée avec succès.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Pointage $pointage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pointage $pointage)
    {
        $workers_ids = Pointage::where('date',$pointage->date)->pluck('daily_worker_id')->toArray();
        return Inertia::render('Pointages/Edit',['item'=>$pointage,'selected_workers'=>DailyWorker::whereIn('id',$workers_ids)->get(),'workers'=>DailyWorker::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePointageRequest $request, Pointage $pointage)
    {
        $pointages = Pointage::where('date',$pointage->date)->get();
        $ids = [];
        $date =  Carbon::parse($request->date)->addHour()->format('Y-m-d');
        foreach ($pointages as $pointage) {
            if(!in_array($pointage->daily_worker_id,$request->ids)){
                $pointage->delete();
            }else{
                $pointage->update(['date'=>$date,'wage'=>$request->wage]);
               $ids[]= $pointage->daily_worker_id;
            }
        }
        $ids = array_diff($request->ids,$ids);
        foreach ($ids as $id) {
            Pointage::create(['daily_worker_id'=>$id,'date'=>$date,'wage'=>$request->wage]);
        }
        return redirect()->route('pointages.index')->banner('Pointage modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pointage $pointage)
    {
        //
    }

    public function WorkersPayment()
    {
        $start = '01'.Carbon::parse(request()->date)->format('/m/Y');
        $end = Carbon::parse(request()->date)->lastOfMonth()->format('d/m/Y');
        $items =  Pointage::whereMonth('date',(int) request()->month)->whereYear('date',(int) request()->year)->orderBy('daily_worker_id')->get()->groupBy('daily_worker_id');
       // return $items;
        $pdf = Pdf::loadView('pdf.workersPayment', ['title_date' => request()->title_date, 'items' => $items,'start'=>$start,'end'=>$end])
            ->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    public function test()
    {
        $start = Carbon::parse('2025-05-01')->format('d/m/Y');
        $end = Carbon::parse('2025-05-01')->lastOfMonth()->format('d/m/Y');
        $items =  Pointage::whereMonth('date',5)->whereYear('date',2025)->orderBy('daily_worker_id')->get()->groupBy('daily_worker_id');
        // return $items;
        $pdf = Pdf::loadView('pdf.workersPayment', ['title_date' => 'Mai 2025', 'items' => $items,'start'=>$start,'end'=>$end])
            ->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

}
