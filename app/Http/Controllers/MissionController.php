<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMissionRequest;
use App\Http\Requests\UpdateMissionRequest;
use App\Models\Car;
use App\Models\Destination;
use App\Models\EntityBordereau;
use App\Models\Equipe;
use App\Models\Mission;
use App\Models\Personnel;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Missions/Index', ['items' => Mission::paginate(10),'sort_fields'=>request()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Missions/Create',['cars'=>Car::all(),'personnels'=>Personnel::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMissionRequest $request)
    {
        $mission = Mission::create($request->all());
        foreach ($request->equipes as $item) {
            $equipe = new Equipe();
            $equipe->mission_id = $mission->id;
            $equipe->save();
            $equipe->update($item);
            $equipe->personnels()->sync($item['personnels_ids']);
        }
        return redirect()->route('missions.index')->banner('Mission Ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mission $mission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mission $mission)
    {
        return Inertia::render('Missions/Edit',['mission'=>$mission,'destinations'=>Destination::all(),'cars'=>Car::all(),'personnels'=>Personnel::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMissionRequest $request, Mission $mission)
    {
        $mission->update($request->all());
        Equipe::destroy($request->deleted);
        foreach ($request->equipes as $item) {
            if(isset($item['personnels_ids'])){
                if($item['id']>0){
                    $equipe = Equipe::find($item['id']);
                    $equipe->update($item);
                }else{
                    $equipe =  new Equipe();
                    $equipe->mission_id = $mission->id;
                    $equipe->save();
                    $equipe->update($item);
                }

                $equipe->personnels()->sync($item['personnels_ids']);
            }
        }
        return redirect()->route('missions.index')->banner('mission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mission $mission)
    {
        //
    }

    public function calendar()
    {
       return Mission::whereBetween('depart_date',[substr(request()->start,0,10),substr(request()->end,0,10)])->get();
    }
}
