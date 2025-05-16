<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMissionRequest;
use App\Http\Requests\UpdateMissionRequest;
use App\Models\Car;
use App\Models\Destination;
use App\Models\EntityBordereau;
use App\Models\Equipe;
use App\Models\MaintenanceType;
use App\Models\Mission;
use App\Models\Personnel;
use App\Models\Setting;
use Inertia\Inertia;
use PhpOffice\PhpWord\Shared\ZipArchive;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Str;
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
        return Inertia::render('Missions/Create',['cars'=>Car::all(),'personnels'=>Personnel::all(),'destinations'=>Destination::all()]);
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

    public function orderDeMission(Mission $mission)
    {
        $mission = \App\Models\Mission::find(1);
        $template = new TemplateProcessor(app_path('Templates/ordre-mission-template.docx'));
        $tempFiles = [];
        foreach ($mission->equipes as $equipe) {
            $template->setValues([
                'mission.nom' => $equipe->driver->fullname,
                'mission.grade' => $equipe->driver->grade,
                'mission.departement' => $equipe->departement?->label,
                'mission.objet' => $mission->mission,
                'mission.destination' => $mission->destination->label,
                'mission.date_depart' => $mission->depart_date,
                'mission.date_retour' => $mission->return_date,
                'mission.transport' => $equipe->car->car_brand?->label . ' ' . $equipe->car->plate,
                'mission.date_creation' => \Carbon\Carbon::parse($mission->created_at)->format('d/m/Y'),
                'mission.president' => Setting::find(1)->value,
            ]);
            $filename = storage_path('app/temp/Ordre_de_mission_' . Str::replace(' ','_',$equipe->driver->fullname) . '.docx');
            $template->saveAs($filename);
            if($equipe->personnels->count()==0)
                return response()->download($filename)->deleteFileAfterSend(true);
            $tempFiles[] = $filename;
            foreach ($equipe->personnels as $personnel) {
                $template2 = new TemplateProcessor(app_path('Templates/ordre-mission-template.docx'));
                $template2->setValues([
                    'mission.nom' => $personnel->fullname,
                    'mission.grade' => $personnel->grade,
                    'mission.departement' => $equipe->departement?->label,
                    'mission.objet' => $mission->mission,
                    'mission.destination' => $mission->destination->label,
                    'mission.date_depart' => $mission->depart_date,
                    'mission.date_retour' => $mission->return_date,
                    'mission.transport' => $equipe->car->car_brand?->label . ' ' . $equipe->car->plate,
                    'mission.date_creation' => \Carbon\Carbon::parse($mission->created_at)->format('d/m/Y'),
                    'mission.president' => Setting::find(1)->value,
                ]);
                $filename = storage_path('app/temp/Ordre_de_mission_' . Str::replace(' ','_',$personnel->fullname). '.docx');
                $template2->saveAs($filename);
                $tempFiles[] = $filename;
            }
        }

        // 2. Create ZIP archive
        $zipPath = storage_path('app/public/ordres_mission.zip');
        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($tempFiles as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        }

        // 3. Clean up temp .docx files
        foreach ($tempFiles as $file) {
            unlink($file);
        }

        // 4. Download the ZIP file
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

}
