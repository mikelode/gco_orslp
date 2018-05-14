<?php

namespace App\Http\Controllers\Gco;

use App\Models\Amplazo;
use App\Models\Proyecto;
use App\Models\Presupuesto;
use App\Models\Progfisica;
use App\Models\Equiprof;
use App\Models\Seleccion;
use App\Models\Uejecutora;
use App\Models\Postor;
use App\Models\Condicionpostor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
        $pyAccess = Auth::user()->tusProject;

        if($pyAccess == 0){ /* zero is all access */
            $pys = Proyecto::with('ejecutor')
                    ->join('gcouejecutora','pryId','=','ejeProject')
                    ->join('gcoprocseleccion','pslProject','=','pryId')
                    ->join('gcopspostores','pslId','=','pstSelectionProc')
                    ->join('gcojpersona','prjId','=','pstJpersona')
                    ->where('pryInvalidate',false)
                    ->get();
        }
        else{
            $pys = Proyecto::with('ejecutor')
                    ->join('gcouejecutora','pryId','=','ejeProject')
                    ->join('gcoprocseleccion','pslProject','=','pryId')
                    ->join('gcopspostores','pslId','=','pstSelectionProc')
                    ->join('gcojpersona','prjId','=','pstJpersona')
                    ->where('pryInvalidate',false)
                    ->whereIn('pryId',explode(',',$pyAccess))
                    ->get();
        }
        //dd(count($pys[0]->ejecutor));
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
        $condicion = Condicionpostor::all();
        $view = view('formularios.nuevo_proyecto', compact('condicion'));
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

            $proyecto = new Proyecto();

            $exception = DB::transaction(function() use($request, &$proyecto){

                $proyecto->prySnip = $request->npySnip;
                $proyecto->pryUnifiedCode = $request->npyCu;
                $proyecto->pryDenomination = $request->npyDenom;
                $proyecto->pryShortDenomination = $request->npyShortdenom;
                $proyecto->pryViabilityResolution = $request->npyResol;
                $proyecto->pryDateResolution = $request->npyDateresol;
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
        }
        catch(Exception $e){
            $msg = 'Error: ' . $e->getMessage() . ' -- ' . $e->getFile() . ' - ' . $e->getLine() . " \n";
            $msgId = 500;
            $url = '';
        }

        return response()->json(compact('msg','msgId','url','proyecto'));
    }
    
    public function store_agrupado(Request $request)
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
                $proyecto->pryViabilityResolution = $request->npyResol;
                $proyecto->pryDateResolution = $request->npyDateresol;
                $proyecto->pryExeMode = $request->npyMod;
                $proyecto->prySisContract = $request->npyContract;
                $proyecto->pryMountContract = $request->npyMountContract;
                $proyecto->pryMountRefValue = $request->npyMountRefValue;
                $proyecto->pryRelationFactor = $request->npyRelFactor;
                $proyecto->pryExeUnit = $ejecutor->ejeId;
                $proyecto->pryDateAgree = $request->npyDateAgree;
                $proyecto->pryMonthTerm = $request->npyMonthTerm;
                $proyecto->pryDaysTerm = $request->npyDaysTerm;
                $proyecto->pryStartDateExe = $request->npyStartDate;
                $proyecto->pryEndDateExe = $request->npyEndDate;
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
        $seleccion = Seleccion::where('pslProject', $request->pyId)->get();
        $postor = Postor::with('individualData')->where('pstSelectionProc',$seleccion[0]->pslId)->get();
        $ejecutor = Proyecto::find($request->pyId)->ejecutor()->get();
        $contratista = Postor::with('individualData')->find($ejecutor[0]->ejeId);
        $equipo = Equiprof::with('individualData')->where('prfUejecutora',$ejecutor[0]->ejeId)->get();
        $condicion = Condicionpostor::all();

        $view = view('formularios.editar_proyecto', compact('proyecto','ejecutor','equipo','seleccion','postor','contratista','condicion'));

        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        try{
            $exception = DB::transaction(function() use($request){

                $proyecto = Proyecto::find($request->npyId);
                $proyecto->prySnip = $request->npySnip;
                $proyecto->pryUnifiedCode = $request->npyCu;
                $proyecto->pryDenomination = $request->npyDenom;
                $proyecto->pryShortDenomination = $request->npyShortdenom;
                $proyecto->pryViabilityResolution = $request->npyResol;
                $proyecto->pryDateResolution = $request->npyDateresol;
                $proyecto->save();
            });

            if(is_null($exception)){
                $msgId = 200;
                $msg = 'Los datos del proyecto se actualizaron correctamente';
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

    public function update_agrupado(Request $request, Proyecto $proyecto)
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
                $proyecto->pryViabilityResolution = $request->npyResol;
                $proyecto->pryDateResolution = $request->npyDateresol;
                $proyecto->pryExeMode = $request->npyMod;
                $proyecto->prySisContract = $request->npyContract;
                $proyecto->pryMountContract = $request->npyMountContract;
                $proyecto->pryMountRefValue = $request->npyMountRefValue;
                $proyecto->pryRelationFactor = $request->npyRelFactor;
                $proyecto->pryExeUnit = $ejecutor->ejeId;
                $proyecto->pryDateAgree = $request->npyDateAgree;
                $proyecto->pryMonthTerm = $request->npyMonthTerm;
                $proyecto->pryDaysTerm = $request->npyDaysTerm;
                $proyecto->pryStartDateExe = $request->npyStartDate;
                $proyecto->pryEndDateExe = $request->npyEndDate;
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
    public function destroy(Request $request)
    {
        try{
            $exception = DB::transaction(function() use($request){
                $pyId = $request->npyIdentify;

                $proyecto = Proyecto::find($pyId);
                $proyecto->pryInvalidate = true;
                $proyecto->pryInvalidateDetail = $request->pyDetailRemove . ' -- Eliminado por el Usuario: AAA con fecha: ' . Carbon::now()->toDateTimeString() . '.';
                $proyecto->save();
            });

            if(is_null($exception)){
                $msg = 'Proyecto eliminado correctamente';
                $msgId = 200;
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

    public function buildSosem(Request $request)
    {
        $pyId = $request->pyId;

        $pry = Proyecto::find($pyId);
        $psl = Seleccion::where('pslProject',$pyId)->get();
        $pst = Postor::with('individualData')->where('pstSelectionProc',$psl[0]->pslId)->where('pstCondition',1)->get();
        $eje = Uejecutora::where('ejeProject',$pyId)->get();
        $eqp = Equiprof::with('individualData')->where('prfUejecutora',$eje[0]->ejeId)->get();
        $pto = Presupuesto::select('*')
                ->with('items')
                ->with('programacion')
                ->join('gcotpresupuesto','tprId','preType')
                ->where('preProject',$pyId)
                ->get();
        $amp = Amplazo::where('ampProject',$pyId)
                ->join('gcocasoampliacion','ampCaso','=','camId')
                ->get();

        $view = view('presentacion.slide_sosem',compact('pry','psl','pst','eje','eqp','pto','amp'));

        return $view;
    }
}
