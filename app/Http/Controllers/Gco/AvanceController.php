<?php

namespace App\Http\Controllers\Gco;

use App\Models\Avance;
use App\Models\Avdetail;
use App\Models\Proyecto;
use App\Models\Itempresupuesto;
use App\Models\Presupuesto;
use App\Models\Equiprof;
use App\Models\Uejecutora;
use App\Models\Partida;
use App\Models\Progfisica;
use App\Models\Resumenavc;
use App\Models\Vpiepresupuesto;
use App\Models\Postor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;
use Excel;
use File;
use App\Traits\BusquedaTablas;

class AvanceController extends Controller
{
    use BusquedaTablas;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pyAccess = Auth::user()->tusProject;

        if($pyAccess == 0){
            $pys = Proyecto::where('pryInvalidate',false)->get();
        }
        else{
            $pys = Proyecto::where('pryInvalidate',false)
                    ->whereIn('pryId',explode(',',$pyAccess))
                    ->get();
        }

        $avn = Avance::all();

        $view = view('gestion.panel_avance',compact('pys','avn'));
        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pry = Proyecto::find($request->pyId);
        $eje = Uejecutora::where('ejeProject',$request->pyId)->get();
        $ptId = $request->ptId;

        if(!$eje->isEmpty()){
            $exe = $eje[0];
            $prf = Equiprof::with('individualData')->where('prfUejecutora',$exe->ejeId)->get();
            $crn = Progfisica::where('prgProject',$pry->pryId)->where('prgBudget',$ptId)->where('prgClosed',false)->get();
            $pto = Presupuesto::find($ptId);
            $pst = Postor::with('individualData')->find($exe->ejePostor);
        }
        else{
            $exe = collect(['sin ejecutor']);
            $prf = collect(['sin equipo']);
            $crn = collect(['sin cronograma']);
            $pto = collect(['sin presupuesto']);
        }
        
        $view = view('formularios.nuevo_avance',compact('pry','exe','prf','crn','pto','pst'));
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

                $valId = $request->navNumber; // navnumber contiene el id de la programacion
                $pyId = $request->hnpyId;
                $ptId = $request->hnavPto;

                $val = Progfisica::find($valId);
                $valNumber = $val->prgNumberVal;

                $prevVal = Progfisica::where('prgProject',$pyId)->where('prgBudget',$ptId)->where('prgNumberVal',$valNumber - 1)->get();
                $prevAvance = 0;

                if(!is_null($val->prgBudgetProgress))
                    throw new Exception("El número de valorización elegido ya presenta avance de metrados registrado \nPara registrar el avance de metrados para una nueva valorización primero debe finalizar el registro de la valorización número: {$valNumber}");

                if(!$prevVal->isEmpty())
                    if($prevVal[0]->prgClosed == false)
                        throw new Exception("No es posible registrar un nuevo avance, porque no se ha finalizado el registro del anterior avance");
                    else
                        $prevAvance = $prevVal[0]->prgBudgetProgress;
                
                $cant_avncs = Avance::where('aprProject',$request->hnpyId)->count();

                $avance = new Avance();
                $avance->aprExecutor = $request->hnpyEjecutor;
                $avance->aprResident = $request->hnpyResidente;
                $avance->aprSupervisor = $request->hnpySupervisor;
                $avance->aprProject = $request->hnpyId;
                $avance->aprBudget = $request->hnavPto;
                $avance->aprProgFisica = $request->navNumber;
                $avance->aprBefprog = $prevAvance;
                $avance->aprRegisterAt = Carbon::now();
                $avance->aprRegisterBy = Auth::user()->tusId . ' - ' . Auth::user()->tusDni;
                $avance->save();

                $val->prgBudgetProgress = $avance->aprId;
                $val->save();

                if($prevAvance == 0){
                    $partidas = Partida::where('parProject',$request->hnpyId)->get();

                    foreach ($partidas as $i => $part) {

                        $avpart = new Avdetail();
                        $avpart->avcPartidaId = $part->parId;
                        $avpart->avcItem = $part->parItem;
                        $avpart->avcBudgetProgress = $avance->aprId;

                        if($part->parMetered == null && $part->parUnit == null){
                            $avpart->avcMeteredBa = null;
                            $avpart->avcMountBa = null;
                            $avpart->avcPercentBa = null;
                            $avpart->avcMeteredCv = null;
                            $avpart->avcMountCv = null;
                            $avpart->avcPercentCv = null;
                            $avpart->avcMeteredCa = null;
                            $avpart->avcMountCa = null;
                            $avpart->avcPercentCa = null;
                            $avpart->avcMeteredBv = null;
                            $avpart->avcMountBv = null;
                            $avpart->avcPercentBv = null;
                        }
                        else{

                            if($cant_avncs == 0){
                                $avpart->avcMeteredBv = $part->parMetered;
                                $avpart->avcMountBv = $part->parPartial;
                                $avpart->avcPercentBv = 100.00;
                            }
                            else{

                            }

                        }

                        $avpart->save();

                    }

                    $itemsresumen = Itempresupuesto::where('iprBudget',$request->hnavPto)->get();

                    foreach ($itemsresumen as $i => $item) {
                        
                        $resumen = new Resumenavc();
                        $resumen->avrBudgetProgress = $avance->aprId;
                        $resumen->avrCodeItem = $item->iprCodeItem;

                        if($cant_avncs == 0){
                            $resumen->avrMountBv = $item->iprItemGeneralMount;
                            $resumen->avrPercentBv = 100.00;
                        }
                        else{

                        }

                        $resumen->save();
                    }

                }
                else{
                    $partidas = Avdetail::where('avcBudgetProgress',$prevAvance)->get();

                    foreach ($partidas as $i => $part) {

                        $avpart = new Avdetail();
                        $avpart->avcPartidaId = $part->avcPartidaId;
                        $avpart->avcItem = $part->avcItem;
                        $avpart->avcBudgetProgress = $avance->aprId;

                        if($part->avcMeteredBa == null && $part->avcMountBa == null){
                            $avpart->avcMeteredBa = null;
                            $avpart->avcMountBa = null;
                            $avpart->avcPercentBa = null;
                            $avpart->avcMeteredCv = null;
                            $avpart->avcMountCv = null;
                            $avpart->avcPercentCv = null;
                            $avpart->avcMeteredCa = null;
                            $avpart->avcMountCa = null;
                            $avpart->avcPercentCa = null;
                            $avpart->avcMeteredBv = null;
                            $avpart->avcMountBv = null;
                            $avpart->avcPercentBv = null;
                        }
                        else{
                            /* $avpart->avcMeteredBa = $part->avcMeteredCa;
                            $avpart->avcMountBa = $part->avcMountCa;
                            $avpart->avcPercentBa = $part->avcPercentCa; no necesario almacenar con la nueva consulta */
                            $avpart->avcMeteredBv = $part->avcMeteredBv;
                            $avpart->avcMountBv = $part->avcMountBv;
                            $avpart->avcPercentBv = $part->avcPercentBv;
                        }

                        $avpart->save();

                    }

                    $itemsresumen = Resumenavc::where('avrBudgetProgress',$prevAvance)->get();

                    foreach ($itemsresumen as $i => $item) {
                        
                        $resumen = new Resumenavc();
                        $resumen->avrBudgetProgress = $avance->aprId;
                        $resumen->avrCodeItem = $item->avrCodeItem;
                        /* $resumen->avrMountBa = $item->avrMountCa;
                        $resumen->avrPercentBa = $item->avrPercentCa; no necesario almacenar con la nueva consulta */
                        $resumen->avrMountBv = $item->avrMountBv;
                        $resumen->avrPercentBv = $item->avrPercentBv;
                        $resumen->save();
                    }
                }
            });

            if(is_null($exception)){
                $msgId = 200;
                $msg = 'Avance registrado correctamente';
                $url = url('presupuesto/avance');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $pyId = $request->pyId;
        $avId = $request->avId; // current progress selected

        $pry = Proyecto::find($pyId);
        $apr = Avance::find($avId);

        /* aprBefProg contain the previus budget progress ID */
        if($apr->aprBefprog == 0){
            $avd = Avdetail::select(DB::raw('*, (avcMeteredCa) as sumMeteredCa, (avcMountCa) as sumMountCa, (avcPercentCa) as sumPercentCa'))
                ->join('gcopartidas','parId','=','avcPartidaId')
                ->where('avcBudgetProgress',$avId)
                ->get();
            $rsmn = Vpiepresupuesto::where('aprId',$avId)->get();
        }
        else{
            $avd = Avdetail::select(DB::raw('*, (pavcMeteredCa + avcMeteredCv) as sumMeteredCa, (pavcMountCa + avcMountCv) as sumMountCa, (pavcPercentCa + avcPercentCv) as sumPercentCa'))
            ->join(
                DB::raw('(select avcId as pavcId, avcPartidaId as pavcPartidaId, avcMeteredCa as pavcMeteredCa, avcMountCa as pavcMountCa, avcPercentCa as pavcPercentCa from gcoavancedet 
                where avcBudgetProgress = ' . $apr->aprBefprog . ') as b'),
                function($join){
                    $join->on('gcoavancedet.avcPartidaId','=','b.pavcPartidaId');
                }
            )
            ->join('gcopartidas','parId','=','avcPartidaId')
            ->where('gcoavancedet.avcBudgetProgress', $apr->aprId)
            ->get();

            $rsmn = Resumenavc::select('*')
            ->join(
                DB::raw('(select avrId as pavrId, avrBudgetProgress as pavrBudgetProgress, avrCodeItem as pavrCodeItem, avrMountCa as pavrMountCa, avrPercentCa as pavrPercentCa from gcoavanceresumen 
                WHERE avrBudgetProgress = ' . $apr->aprBefprog . ') as z '),
                function($join){
                    $join->on('gcoavanceresumen.avrCodeItem','=','z.pavrCodeItem');
                }
            )
            ->join('gcoavancepres','gcoavanceresumen.avrBudgetProgress','=','gcoavancepres.aprId')
            ->join('gcoitempresupuesto', function($join){
                $join->on('gcoavancepres.aprBudget','=','gcoitempresupuesto.iprBudget')
                        ->on('gcoavanceresumen.avrCodeItem','=','gcoitempresupuesto.iprCodeItem');
                }
            )
            ->where('gcoavanceresumen.avrBudgetProgress', $apr->aprId)
            ->get();
        }

        //$pto = Presupuesto::where('preProject',$pyId)->get();
        

        $valorizacion = Progfisica::where('prgProject',$pyId)->where('prgBudgetProgress',$avId)->first();

        //$view = view('formularios.editar_avance',compact('pry','apr','avd','pto','rsmn'));
        $view = view('formularios.editar_avance',compact('avd','rsmn','valorizacion','pry'));

        return $view;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $close)
    {
        try{

            $pyId = $request->npyId;
            $apId = $request->nbpId;

            $exception = DB::transaction(function() use($request, $close){

                $pyId = $request->npyId;
                $apId = $request->nbpId;
                $ptId = $request->nptId;

                $gridPartidas = (array) json_decode($request->dataGridDetail);
                $gridResumen = (array) json_decode($request->dataGridResume);

                foreach ($gridPartidas as $part) {

                    if(is_null($part->parMetered) && $part->parUnit == ''){
                        continue;
                    }

                    if(!is_numeric(trim($part->avcMeteredCv))){
                        if(strlen(trim($part->avcMeteredCv)) != 0)
                            throw new Exception("El metrado ingresado en la partida $part->parItem debe ser un número. \n- Verifique que no existan comas o espacios en blanco.\n");
                    }

                    $partida = Avdetail::find($part->avcId);
                    /*$partida->avcMeteredBa = $part->avcMeteredBa;
                    $partida->avcMountBa = $part->avcMountBa;
                    $partida->avcPercentBa = $part->avcPercentBa; no necesario almacenar con la nueva consulta */
                    $partida->avcMeteredCv = trim($part->avcMeteredCv) == '' ? null : $part->avcMeteredCv;
                    $partida->avcMountCv = $part->avcMountCv;
                    $partida->avcPercentCv = $part->avcPercentCv;
                    $partida->avcMeteredCa = $part->sumMeteredCa; /* change avc to sum, to calculate sum with zero when progress was 100% */
                    $partida->avcMountCa = $part->sumMountCa;
                    $partida->avcPercentCa = $part->sumPercentCa;
                    $partida->avcMeteredBv = $part->avcMeteredBv;
                    $partida->avcMountBv = $part->avcMountBv;
                    $partida->avcPercentBv = $part->avcPercentBv;
                    $partida->save();
                }

                $proyecto = Proyecto::find($pyId);
                $presupuesto = Itempresupuesto::find($proyecto->pryBaseBudget);
                $presupuestoCode = $presupuesto->iprCodeItem;


                foreach ($gridResumen as $item) {
                    $resumen = Resumenavc::find($item->avrId);
                    /* $resumen->avrMountBa = $item->avrMountBa;
                    $resumen->avrPercentBa = $item->avrPercentBa; no necesario almacenar con la nueva consulta */
                    $resumen->avrMountCv = $item->avrMountCv;
                    $resumen->avrPercentCv = $item->avrPercentCv;
                    $resumen->avrMountCa = $item->avrMountCa;
                    $resumen->avrPercentCa = $item->avrPercentCa;
                    $resumen->avrMountBv = $item->avrMountBv;
                    $resumen->avrPercentBv = $item->avrPercentBv;
                    $resumen->save();

                    if($resumen->avrCodeItem == $presupuestoCode){
                        $montoEjecutado = $resumen->avrMountCv;
                        $porceEjecutado = $resumen->avrPercentCv;
                        $acumuEjecutado = $resumen->avrPercentCa;
                    }

                }

                $avancePresupuesto = Avance::find($apId);

                $cronograma = Progfisica::find($avancePresupuesto->aprProgFisica);
                $cronograma->prgBudgetProgress = $avancePresupuesto->aprId;
                $cronograma->prgMountExec = $montoEjecutado;
                $cronograma->prgPercentExec = $porceEjecutado / 100;
                $cronograma->prgAggregateExec = $acumuEjecutado / 100;
                $cronograma->prgClosed = $close;
                $cronograma->prgStatus = $this->get_status_obra($cronograma->prgAggregate, $acumuEjecutado/100);
                $cronograma->save();

            });

            if(is_null($exception)){
                $msgId = 200;
                $msg = 'Las modificaciones realizadas han sido almacenadas con éxito';
                $url = url('ver/avance');
            }
            else{
                throw new Exception($exception);
            }

        }catch(Exception $e){
            $msg = 'Error: ' . $e->getMessage() . ' * ' . $e->getLine() . " \n";
            $msgId = 500;
            $url = '';
        }
        
        return response()->json(compact('msg','msgId','url','pyId','apId'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list(Request $request)
    {
        $ptId = $request->ptId;

        $avancesPy = Avance::where('aprBudget',$ptId)->get();

        $optionHtml = '<optgroup label="Opciones"><option value="NA"> Elija o registre una valorización </option>';
        if(Auth::user()->hasPermission(14)){
            $optionHtml .= '<option value="CP"> Registrar Nueva Valorización </option></optgroup>';
        }
        $optionHtml .= '<optgroup label="Valorizaciones registradas">';

        foreach($avancesPy as $av){
            $programacion = Progfisica::find($av->aprProgFisica);
            $optionHtml .= '<option value="' . $av->aprId . '">' . $programacion->prgNumberVal . ': ' . $programacion->prgStartPeriod . ' a ' . $programacion->prgEndPeriod . '</option>';
        }

        $optionHtml .= '</optgroup>';

        
        return response()->json(compact('avancesPy','optionHtml'));
    }
}
