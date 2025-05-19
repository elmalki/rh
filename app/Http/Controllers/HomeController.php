<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Car;
use App\Models\CarMaintenance;
use App\Models\Leave;
use App\Models\Personnel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke()
    {
       /* $items = Car::with(['maintenance_types' => function ($query) {
            $query->wherePivot('next_km', '<', DB::raw('cars.kilometrage'));
        }])->get();*/
        $nbre_de_fonctionnaire = Personnel::all()->countBy('sexe');
        $cars = Car::all();
        $nbre_de_vihecules = $cars->count();
        $marques = $cars->countBy('car_brand.label')->sortDesc();
        $carburants = $cars->countBy('fuel.label')->sortDesc();
        $types = $cars->countBy('car_type.label')->sortDesc();
        $nbre_de_conge = Leave::where('end_date','>',Carbon::now())->count();
        $budget = Budget::select(['value', 'remaining'])
            ->whereYear('created_at', Carbon::now()->year)
            ->get();

        $budget = [
            'restant' => $budget->sum('remaining'),
            'consomme' => $budget->sum('value')-$budget->sum('remaining'),
        ];
        $items = CarMaintenance::where('is_last_maintenance_type',true)->whereHas('car' , function ($query) {
            $query->whereColumn(DB::raw('car_maintenance_type.next_km'),'<','cars.kilometrage');
        })
            ->with(['car','maintenance_type'])
            ->get();
        return Inertia::render('Dashboard',compact('items','nbre_de_fonctionnaire','nbre_de_vihecules', 'nbre_de_conge','marques','carburants','types','budget'));
    }
}
