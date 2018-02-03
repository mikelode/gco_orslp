<?php

namespace App\Http\Controllers\Gco;

use App\Models\Proyecto;
use App\Models\Equiprof;
use App\Models\Uejecutora;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Exception;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pys = Proyecto::with('ejecutor')->get();
        $tms = Equiprof::with('individualData')->get();

        $view = view('gestion.panel_proyectos', compact('pys','tms'));

        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $view = view('gestion.nuevo_proyecto');
        return $view;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $exception = DB::transaction(function() use($request){

                $ejecutor = new Uejecutora();
                $ejecutor->ejePersonType = $request->nejPers;
                $ejecutor->ejeRegistType = $request->nejTipodoc;
                $ejecutor->ejeRegistNumber = $request->nejNumdoc;
                $ejecutor->ejeBusiName = $request->nejDenom;
                $ejecutor->ejeAcronym = $request->nejSigla;
                $ejecutor->ejeLegalRepDni = $request->nejRepdni;
                $ejecutor->ejeLegalRepName = $request->nejRepname;
                $ejecutor->ejeLegalRepPaterno = $request->nejReppat;
                $ejecutor->ejeLegalRepMaterno = $request->nejRepmat;
                $ejecutor->save();

                $nprofs = count($request->nteamId);
                for($i = 0; $i < $nprofs; $i++){
                    $team = new Equiprof();
                    $team->prfPerson = $request->nteamId[$i];
                    $team->prfJob = $request->nteamJob[$i];
                    $team->prfUejecutora = $ejecutor->ejeId;
                    $team->save();
                }

                $proyecto = new Proyecto();
                $proyecto->prySnip = $request->npySnip;
                $proyecto->pryUnifiedCode = $request->npyCu;
                $proyecto->pryDenomination = $request->npyDenom;
                $proyecto->pryShortDenomination = $request->npyShortdenom;
                $proyecto->pryViabilityDatePip = $request->npyDateviab;
                $proyecto->pryViabilityDateSD = $request->npyDateresol;
                $proyecto->pryViabilityResolution = $request->npyResol;
                $proyecto->pryExeMode = $request->npyMod;
                $proyecto->pryExeUnit = $ejecutor->ejeId;
                $proyecto->save();

            });

            if(is_null($exception)){
                $msgId = 200;
                $msg = 'Proyecto registrado correctamente';
                $url = url('proyecto');
            }
            else{
                throw new Exception($exception);
            }

        }catch(Exception $e){
            $msg = 'Error: ' . $e->getMessage() . ' -- ' . $e->getFile() . ' - ' . $e->getLine() . " \n";
            $msgId = 500;
            $url = '';
        }

        return response()->json(compact('msg','msgId','url'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function show(Proyecto $proyecto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $proyecto = Proyecto::find($request->pyId);
        $ejecutor = Uejecutora::find($proyecto->pryExeUnit);
        $equipo = Equiprof::with('individualData')->where('prfUejecutora',$ejecutor->ejeId)->get();

        $view = view('gestion.editar_proyecto', compact('proyecto','ejecutor','equipo'));

        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyecto $proyecto)
    {
        try{
            $exception = DB::transaction(function() use($request){

                $ejecutor = Uejecutora::find($request->nejId);
                $ejecutor->ejePersonType = $request->nejPers;
                $ejecutor->ejeRegistType = $request->nejTipodoc;
                $ejecutor->ejeRegistNumber = $request->nejNumdoc;
                $ejecutor->ejeBusiName = $request->nejDenom;
                $ejecutor->ejeAcronym = $request->nejSigla;
                $ejecutor->ejeLegalRepDni = $request->nejRepdni;
                $ejecutor->ejeLegalRepName = $request->nejRepname;
                $ejecutor->ejeLegalRepPaterno = $request->nejReppat;
                $ejecutor->ejeLegalRepMaterno = $request->nejRepmat;
                $ejecutor->save();

                $nprofs = count($request->nteamId);
                for($i = 0; $i < $nprofs; $i++){
                    $team = new Equiprof();
                    $team->prfPerson = $request->nteamId[$i];
                    $team->prfJob = $request->nteamJob[$i];
                    $team->prfUejecutora = $ejecutor->ejeId;
                    $team->save();
                }

                $proyecto = Proyecto::find($request->npyId);
                $proyecto->prySnip = $request->npySnip;
                $proyecto->pryUnifiedCode = $request->npyCu;
                $proyecto->pryDenomination = $request->npyDenom;
                $proyecto->pryShortDenomination = $request->npyShortdenom;
                $proyecto->pryViabilityDatePip = $request->npyDateviab;
                $proyecto->pryViabilityDateSD = $request->npyDateresol;
                $proyecto->pryViabilityResolution = $request->npyResol;
                $proyecto->pryExeMode = $request->npyMod;
                $proyecto->pryExeUnit = $ejecutor->ejeId;
                $proyecto->save();

            });

            if(is_null($exception)){
                $msgId = 200;
                $msg = 'Proyecto actualizado correctamente';
                $pyId = $request->npyId;
            }
            else{
                throw new Exception($exception);
            }

        }catch(Exception $e){
            $msg = 'Error: ' . $e->getMessage() . ' -- ' . $e->getFile() . ' - ' . $e->getLine() . " \n";
            $msgId = 500;
            $pyId = '';
        }

        return response()->json(compact('msg','msgId','pyId'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyecto $proyecto)
    {
        //
    }

    public function postEditStatusTeam(Request $request)
    {
        $profId = $request->pk;
        $statusValue = $request->value;

        $team = Equiprof::find($profId);
        $team->prfDisable = $statusValue == 'A' ? false : true;
        
        if($team->save()){
            $success = true;
            $msg = 'Estado cambiado correctamente';
        }
        else{
            $success = false;
            $msg = 'Error, refresque la página e intente de nuevo';
        }

        return response()->json(compact('success','msg'));
    }

    public function postEditJobTeam(Request $request)
    {
        $profId = $request->pk;
        $jobValue = $request->value;

        $team = Equiprof::find($profId);
        $team->prfJob = $jobValue;

        if($team->save()){
            $success = true;
            $msg = 'Estado cambiado correctamente';
        }
        else{
            $success = false;
            $msg = 'Error, refresque la página e intente de nuevo';
        }

        return response()->json(compact('success','msg'));

    }
}
