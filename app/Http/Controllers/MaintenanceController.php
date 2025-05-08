<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Requests\UpdateMaintenanceRequest;
use App\Models\Car;
use App\Models\Maintenance;
use App\Models\MaintenanceType;
use App\Models\MonthlyReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Inertia\Inertia;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Maintenances/Index', ['items' => Maintenance::orderBy('id','desc')->paginate(10),'sort_fields'=>request()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Maintenances/Create',['cars'=>Car::all(),'maintenance_types'=>MaintenanceType::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaintenanceRequest $request)
    {

        $maintenance = Maintenance::create( $request->all() );
        $maintenance->refresh();
        $date = Carbon::parse($request->date)->addHour()->format('Y-m-d');
        $car  = Car::find($request->car_id);
        MonthlyReport::create(['car_id'=>$request->car_id,'maintenance_id'=>$maintenance->id,'date'=>$date]);
        if($car->kilometrage<$request->kilometrage)
             $car->update(['kilometrage'=>$request->kilometrage]);
        foreach($request->maintenance_types as $item){
            $data = ['maintenance_id'=>$maintenance->id,'date' => $date, 'km' => $request->kilometrage, 'next_km' => MaintenanceType::find($item['maintenance_type_id'])->kilometrage??0 + $request->kilometrage];
            if (isset($item['montant'])){
                $data['montant'] = $item['montant'];
            }
            if (isset($item['observation'])){
                $data['observation'] = $item['observation'];
            }
            $car->maintenance_types()->syncWithoutDetaching([
                $item['maintenance_type_id']=>$data
            ]);
        }

        return redirect()->route('maintenances.index')->banner('Maintenance a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        return Inertia::render('Maintenances/Edit',['maintenance'=>$maintenance,'cars'=>Car::all(),'maintenance_types'=>MaintenanceType::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaintenanceRequest $request, Maintenance $maintenance)
    {
        //return $request->all();
        $maintenance->update( $request->all() );
        $monthlyReport = MonthlyReport::where('maintenance_id',$maintenance->id)->get()->first();
        $car  = Car::find($request->car_id);
        if($car->kilometrage<$request->kilometrage)
            $car->update(['kilometrage'=>$request->kilometrage]);
        $date = Carbon::parse($request->date)->addHour()->format('Y-m-d');
        $monthlyReport->update(['car_id'=>$request->car_id,'date'=>$date]);
        $ids = [];
        foreach($request->maintenance_types as $item){
            if ( isset($item['maintenance_type_id'])){
                $data = ['maintenance_id'=>$maintenance->id,'date' => $date, 'km' => $request->kilometrage, 'next_km' => MaintenanceType::find($item['maintenance_type_id'])->kilometrage??0 + $request->kilometrage];
                if (isset($item['montant'])){
                    $data['montant'] = $item['montant'];
                }
                if (isset($item['observation'])){
                    $data['observation'] = $item['observation'];
                }
                $car->maintenance_types()->syncWithoutDetaching([
                    $item['maintenance_type_id']=>$data
                ]);
                $ids[] = $item['maintenance_type_id'];
                if($item['id']>0 && $item['maintenance_type_id']!=$item['id'])
                     $car->maintenance_types()->detach($item['id']);
            }else{
                $ids[] = $item['id'];
            }
        }
        $car->maintenance_types()->sync($ids);
        return  redirect()->route('maintenances.index')->banner('Maintenance a été modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        //
    }

    public function etat()
    {
        return Inertia::render('Maintenances/Etat', ['maintenance_types' => MaintenanceType::all()]);
    }

    public function getEtat()
    {
        return Car::whereHas('maintenance_types', function ($query) {
            $query->where('maintenance_type_id', request()->maintenance_type_id);
        })->with(['maintenance_types' => function ($query) {
            $query->wherePivot('maintenance_type_id', request()->maintenance_type_id);
        }])->get();
    }

    public function getEtatPdf()
    {
        $cars = $this->getEtat();
        $pdf = Pdf::loadView('pdf.etat', ['date' => request()->date, 'cars' => $cars])
            ->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
}

