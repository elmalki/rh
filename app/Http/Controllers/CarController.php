<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarType;
use App\Models\Fuel;
use App\Models\Paper;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $perPage=10;
    public function index()
    {
        $cars = Car::query();
        $cars =  $cars->orderBy(request()->field??'id', request()->order==1?'desc':'asc')->paginate($this->perPage);
        return Inertia::render('Cars/Index', ['items'=>$cars,'sort_fields'=>request()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Cars/Create', ['fuels'=>Fuel::all(),'brands'=>CarBrand::all(),'types'=>CarType::all(),'papers'=>Paper::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
       // return $request->all();
        $car = Car::create($request->all());
        foreach($request->papers as $paper){
            $file_name = $this->createFileName($paper['file']);
            $car->papers()->attach($paper['paper_id'],['file'=>$file_name]);
        }
        return Redirect::route('cars.index')->banner('Vihécule créé avec succè');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return Inertia::render('Cars/Edit', ['car'=>$car,'fuels'=>Fuel::all(),'brands'=>CarBrand::all(),'types'=>CarType::all(),'papers'=>Paper::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        //return $request->all();
        $car->update($request->all());
        //get papers relationship ids
        $paper_ids =  $car->papers->pluck('id');
        foreach($request->papers as $paper){
            //remove the id from the collection ids so we can detach the rest
            $paper_ids = $paper_ids->reject(function ($value) use($paper){
                return $value === $paper['id'];
            });
            //this paper already exists in the relationship
            if(isset($paper['pivot'])){
                if(isset($paper['date']))
                    $car->papers()->updateExistingPivot($paper['id'], ['date' =>Carbon::parse($paper['date'])->addDay()->format('Y-m-d')]);
                //check if the file is changed: remove the old one and add the new one
                if(isset($paper['paper_id']) && $paper['file']){
                    $this->createFileName($paper['file'],$paper['pivot']['file']);
                }
            }else{
               $file_name = $this->createFileName($paper['file']);
               $car->papers()->attach($paper['paper_id'],['file'=>$file_name,'date'=>Carbon::parse($paper['date'])->addDay()->format('Y-m-d')]);
            }
        }
        //remove files before detaching
        $car->papers->whereIn('id',$paper_ids)->each(function($paper) use($car){
            Storage::delete('public/' .$paper->pivot->file);
            $car->papers()->detach($paper->id);
        });
        return Redirect::route('cars.index')->banner('Vihécule est modifié avec succè');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }

    private function createFileName($file,$file_name=null)
    {
        if ($file_name)
            Storage::delete('public/' .$file_name);
        else
            $file_name = Str::random(16) . '.pdf';
        $exploded = explode(',', $file);
        $decoded = base64_decode($exploded[1]);
        Storage::put('public/' . $file_name, $decoded);
        return $file_name;
    }
}
