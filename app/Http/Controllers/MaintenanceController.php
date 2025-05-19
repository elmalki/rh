<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Requests\UpdateMaintenanceRequest;
use App\Models\Car;
use App\Models\CarMaintenance;
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
        $car->refresh();
        foreach($request->maintenance_types as $item){
            $km = MaintenanceType::find($item['maintenance_type_id'])->kilometrage??0;
            //check if this maintenance type already exists between this car and the type if exists it want be the last one
            $maintenance_car_maintenanceType = CarMaintenance::where('car_id',$car->id)->where('maintenance_type_id',$item['maintenance_type_id'])->where('is_last_maintenance_type',true)->first();
            if($maintenance_car_maintenanceType){
                $maintenance_car_maintenanceType->update(['is_last_maintenance_type'=>false]);
            }
            $data = ['maintenance_type_id'=> $item['maintenance_type_id'],'car_id'=>$car->id,'maintenance_id'=>$maintenance->id,'date' => $date, 'km' => $request->kilometrage, 'next_km' => $km + $car->kilometrage,'is_last_maintenance_type'=>true];
            if (isset($item['montant'])){
                $data['montant'] = $item['montant'];
            }
            if (isset($item['observation'])){
                $data['observation'] = $item['observation'];
            }
            CarMaintenance::create($data);
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
        $car->refresh();
        $date = Carbon::parse($request->date)->addHour()->format('Y-m-d');
        $monthlyReport->update(['car_id'=>$request->car_id,'date'=>$date]);
        $ids = [];
        foreach($request->maintenance_types as $item){
            if ( isset($item['maintenance_type_id'])){
                $km = MaintenanceType::find($item['maintenance_type_id'])->kilometrage??0;
                $data = ['maintenance_type_id'=> $item['maintenance_type_id'],'car_id'=>$car->id,'maintenance_id'=>$maintenance->id,'date' => $date, 'km' => $request->kilometrage, 'next_km' => $km + $request->kilometrage];
                if (isset($item['montant'])){
                    $data['montant'] = $item['montant'];
                }
                if (isset($item['observation'])){
                    $data['observation'] = $item['observation'];
                }
                $maintenance_car_maintenance_type = CarMaintenance::where('maintenance_id',$maintenance->id)->where('car_id',$car->id)->where('maintenance_type_id',$item['maintenance_type_id'])->first();
                if($maintenance_car_maintenance_type){
                    $maintenance_car_maintenance_type->update($data);
                }else{
                    CarMaintenance::create($data);
                }

                $ids[] = $item['maintenance_type_id'];
                if($item['id']>0 && $item['maintenance_type_id']!=$item['id']){
                    CarMaintenance::where('car_id',$car->id)->where('maintenance_id',$maintenance->id)->where('maintenance_type_id',$item['id'])->delete();
                    //$maintenance->maintenance_types()->detach($item['id']);
                }
            }else{
                $ids[] = (int)$item['id'];
            }
        }
        CarMaintenance::where('car_id',$car->id)->where('maintenance_id',$maintenance->id)->whereNotIn('maintenance_type_id',$ids)->delete();
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
        return Inertia::render('Maintenances/Etat', ['maintenance_types' => MaintenanceType::whereNotNull('kilometrage')->get()]);
    }

    public function getEtat()
    {
        return Car::whereHas('maintenance_types', function ($query) {
            $query->where('maintenance_type_id', request()->maintenance_type_id);
        })->with(['maintenance_types' => function ($query) {
            $query->wherePivot('maintenance_type_id', request()->maintenance_type_id)
            ->wherePivot('is_last_maintenance_type', true);
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

