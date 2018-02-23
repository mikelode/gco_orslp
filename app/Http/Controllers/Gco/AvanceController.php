<?php

namespace App\Http\Controllers\Gco;

use App\Models\Avance;
use App\Models\Avdetail;
use App\Models\Proyecto;
use App\Models\Presupuesto;
use App\Models\Equiprof;
use App\Models\Uejecutora;
use App\Models\Partida;
use App\Models\Progfisica;
use App\Models\Resumenavc;
use App\Models\Vpiepresupuesto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Exception;
use Excel;
use File;

class AvanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pys = Proyecto::where('pryInvalidate',false)->get();
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

        if(!is_null($pry->pryExeUnit)){
            $exe = Uejecutora::find($pry->pryExeUnit);
            $prf = Equiprof::with('individualData')->get();
            $crn = Progfisica::where('prgProject',$pry->pryId)->where('prgClosed',false)->get();
        }
        else{
            $exe = collect(['sin ejecutor']);
            $prf = collect(['sin equipo']);
            $crn = collect(['sin cronograma']);
        }

        $view = view('formularios.nuevo_avance',compact('pry','exe','prf','crn'));
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

                $val = Progfisica::find($valId);
                $valNumber = $val->prgNumberVal;

                $prevVal = Progfisica::where('prgProject',$pyId)->where('prgNumberVal',$valNumber - 1)->get();
                $prevAvance = 0;

                if(!is_null($val->prgBudgetProgress))
                    throw new Exception("EL número de valorización elegido ya presenta avance de metrados registrado \nPara registrar el avance de metrados para una nueva valorización primero debe finalizar el registro de la valorización número: {$valNumber}");

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
                $avance->aprProgFisica = $request->navNumber;
                $avance->aprPeriod = $request->navPeriod;
                $avance->aprStartDate = $request->navStartDate;
                $avance->aprEndDate = $request->navEndDate;
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

                    $itemsresumen = Presupuesto::where('preProject',$request->hnpyId)->get();

                    foreach ($itemsresumen as $i => $item) {
                        
                        $resumen = new Resumenavc();
                        $resumen->avrBudgetProgress = $avance->aprId;
                        $resumen->avrCodeItem = $item->preCodeItem;

                        if($cant_avncs == 0){
                            $resumen->avrMountBv = $item->preItemGeneralMount;
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
                            $avpart->avcMeteredBa = $part->avcMeteredCa;
                            $avpart->avcMountBa = $part->avcMountCa;
                            $avpart->avcPercentBa = $part->avcPercentCa;
                            /*$avpart->avcMeteredCv = null;
                            $avpart->avcMountCv = null;
                            $avpart->avcPercentCv = null;
                            $avpart->avcMeteredCa = null;
                            $avpart->avcMountCa = null;
                            $avpart->avcPercentCa = null;*/
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
                        $resumen->avrMountBa = $item->avrMountCa;
                        $resumen->avrPercentBa = $item->avrPercentCa;
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
        $avId = $request->avId;

        //$pry = Proyecto::find($pyId);
        //$apr = Avance::find($avId);

        $avd = Avdetail::select('*')
                ->join('gcopartidas','parId','=','avcPartidaId')
                ->where('avcBudgetProgress',$avId)
                ->get();
        //$pto = Presupuesto::where('preProject',$pyId)->get();
        $rsmn = Vpiepresupuesto::where('aprId',$avId)->get();
        $valorizacion = Progfisica::where('prgProject',$pyId)->where('prgBudgetProgress',$avId)->first();

        //$view = view('formularios.editar_avance',compact('pry','apr','avd','pto','rsmn'));
        $view = view('formularios.editar_avance',compact('avd','rsmn','valorizacion'));

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

            $exception = DB::transaction(function() use($request, $close){

                $pyId = $request->npyId;
                $apId = $request->nbpId;

                $gridPartidas = (array) json_decode($request->dataGridDetail);
                $gridResumen = (array) json_decode($request->dataGridResume);

                foreach ($gridPartidas as $part) {
                    $partida = Avdetail::find($part->avcId);
                    $partida->avcMeteredBa = $part->avcMeteredBa;
                    $partida->avcMountBa = $part->avcMountBa;
                    $partida->avcPercentBa = $part->avcPercentBa;
                    $partida->avcMeteredCv = $part->avcMeteredCv;
                    $partida->avcMountCv = $part->avcMountCv;
                    $partida->avcPercentCv = $part->avcPercentCv;
                    $partida->avcMeteredCa = $part->avcMeteredCa;
                    $partida->avcMountCa = $part->avcMountCa;
                    $partida->avcPercentCa = $part->avcPercentCa;
                    $partida->avcMeteredBv = $part->avcMeteredBv;
                    $partida->avcMountBv = $part->avcMountBv;
                    $partida->avcPercentBv = $part->avcPercentBv;
                    $partida->save();
                }

                $proyecto = Proyecto::find($pyId);
                $presupuesto = Presupuesto::find($proyecto->pryBaseBudget);
                $presupuestoCode = $presupuesto->preCodeItem;


                foreach ($gridResumen as $item) {
                    $resumen = Resumenavc::find($item->avrId);
                    $resumen->avrMountBa = $item->avrMountBa;
                    $resumen->avrPercentBa = $item->avrPercentBa;
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
                $cronograma->save();

            });

            if(is_null($exception)){
                $msgId = 200;
                $msg = 'Las modificaciones realizadas han sido almacenadas con éxito';
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
        $pyId = $request->pyId;

        $avancesPy = Avance::where('aprProject',$pyId)->get();

        $optionHtml = '<optgroup label="Opciones"><option value="NA"> Elija o agregue un avance </option>';
        $optionHtml .= '<option value="CP"> Registrar Nuevo Avance </option></optgroup>';
        $optionHtml .= '<optgroup label="Avances registrados">';

        foreach($avancesPy as $av){
            $optionHtml .= '<option value="' . $av->aprId . '">' . $av->aprPeriod . ' - ' . $av->aprStartDate . ' a ' . $av->aprEndDate .'</option>';
        }

        $optionHtml .= '</optgroup>';

        
        return response()->json(compact('avancesPy','optionHtml'));
    }
}
