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
        $dates = Pointage::with('workers')->paginate(10);

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
        return Inertia::render('Pointages/Create',['wage'=>Pointage::latest()->first()?->wage,'workers'=>DailyWorker::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePointageRequest $request)
    {
        $date =  Carbon::parse($request->date)->addHour()->format('Y-m-d');
        $pointage = Pointage::updateOrCreate(['date'=>$date],['wage'=>$request->wage]);
        $pointage->workers()->sync(collect($request->workers)->pluck('id')->toArray());
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
        return Inertia::render('Pointages/Edit',['item'=>$pointage->load('workers'),'workers'=>DailyWorker::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePointageRequest $request, Pointage $pointage)
    {
        $date =  Carbon::parse($request->date)->addHour()->format('Y-m-d');
        $pointage->update(['date'=>$date,'wage'=>$request->wage]);
        $pointage->workers()->sync($request->ids);
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
       // return $items;
        $items =  DailyWorker::whereHas('pointages', function ($query) {
            $query->whereYear('date', request()->year)
                ->whereMonth('date', request()->month);
        })->with(['pointages' => function ($query) {
            $query->whereYear('date', request()->year)
                ->whereMonth('date', request()->month);
        }])->get();
        $items->each(function ($item) {
            $item['dates'] = $item['pointages']->pluck('date')->map(function($el){return substr($el,8,2);}); ;
        });
        $pdf = Pdf::loadView('pdf.payment', ['title_date' => request()->title_date, 'workers' => $items,'start'=>$start,'end'=>$end])
            ->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    public function test()
    {
        $start = Carbon::parse('2025-05-01')->format('d/m/Y');
        $end = Carbon::parse('2025-05-01')->lastOfMonth()->format('d/m/Y');
        $items =  DailyWorker::whereHas('pointages', function ($query) {
            $query->whereYear('date', 2025)
                ->whereMonth('date', 5);
        })->with(['pointages' => function ($query) {
            $query->whereYear('date', 2025)
                ->whereMonth('date', 5);
        }])->get();
        $items->each(function ($item) {
            $item['dates'] = $item['pointages']->pluck('date')->map(function($el){return substr($el,8,2);}); ;
        });
        return view('pdf.payment', ['title_date' => 'Mai 2025', 'workers' => $items,'start'=>$start,'end'=>$end]);
        $pdf = Pdf::loadView('pdf.workersPayment', ['title_date' => 'Mai 2025','workers'=>DailyWorker::all(), 'items' => $items,'start'=>$start,'end'=>$end])
            ->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

}
