<?php

namespace App\Http\Controllers\Gco;

use App\Models\Avance;
use App\Models\Avdetail;
use App\Models\Proyecto;
use App\Models\Presupuesto;
use App\Models\Equiprof;
use App\Models\Uejecutora;
use App\Models\Partida;
use App\Models\Resumenavc;
use App\Models\Progfisica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Excel;
use File;

class ProgramaFisicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pys = Proyecto::where('pryInvalidate',false)->get();

        $view = view('gestion.panel_progfisica', compact('pys'));

        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $pyId = $request->pyId;

        $resumen = Presupuesto::where('preProject',$pyId)->get();

        $cronograma = array();

        $pry = Proyecto::find($pyId);
        $fecIni = Carbon::parse($pry->pryStartDateExe);
        $fecFin = Carbon::parse($pry->pryEndDateExe);
        $plazoMeses = $pry->pryMonthTerm;
        $plazoDias = $pry->pryDaysTerm;
        $fechaValorizacion = $fecIni;
        $i = 0;

        while($plazoMeses > 0){

            $i++;
            $valorizacion = array('val' => $i, 'fecha' => $fechaValorizacion->endOfMonth());
            array_push($cronograma,$valorizacion);

            $fechaValorizacion = $fechaValorizacion->copy()->addDays(1);

            if($plazoMeses == 1){
                if($fecFin->diffInDays($fechaValorizacion) < $fechaValorizacion->daysInMonth){
                    $valorizacion = array('val' => $i+1, 'fecha' => $fecFin);
                    array_push($cronograma, $valorizacion);
                }
            }

            $plazoMeses--;
        }

        array_push($cronograma, array('val' => 'TOTAL','fecha' => null));

        $view = view('formularios.nuevo_programacion',compact('pry','cronograma','resumen'));

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

                $pyId = $request->hnpyId;
                $keyPto = explode('-', $request->hnpyResumenPto);
                $ptoId = $keyPto[0];

                $pry = Proyecto::find($pyId);
                $pry->pryBaseBudget = $ptoId;
                $pry->save();

                foreach ($request->nvalNumber as $i => $val) {
                    
                    $cronograma = new Progfisica();
                    $cronograma->prgProject = $pyId;
                    $cronograma->prgNumberVal = $val;
                    $cronograma->prgPeriodo = $request->nvalPeriod[$i];
                    $cronograma->prgMount = floatval(str_replace(',', '', $request->nvalMount[$i]));
                    $cronograma->prgPercent = floatval($request->nvalPrcnt[$i]) / 100;
                    $cronograma->prgAggregate = floatval($request->nvalAggrt[$i]) / 100;
                    $cronograma->save();

                    unset($cronograma);

                }
            });

            if(is_null($exception)){
                $msgId = 200;
                $msg = 'Cronograma registrado correctamente';
                $url = url('presupuesto/programacion');
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
    public function show(Request $request, $curva)
    {
        $pyId = $request->pyId;
        $cronograma = Progfisica::where('prgProject',$pyId)->orderBy('prgNumberVal','asc')->get();

        if($curva == '1'){
            $chartData = '';
            $labels = $cronograma->pluck('prgPeriodo');

            $programado = $cronograma->map(function($item,$key){
                return $item->prgAggregate * 100;
            });

            $ejecutado = $cronograma->map(function($item,$key){
                return $item->prgAggregateExec * 100;
            });

            $chartData .= "{ 
                labels: $labels, 
                datasets: [{
                    label: 'Cantidad Programada',
                    fill: false,
                    backgroundColor: 'rgba(255,99,132,0.5)',
                    borderColor: 'rgb(255,99,132)',
                    data:$programado
                },{
                    label: 'Cantidad Ejecutada',
                    fill: false,
                    backgroundColor: 'rgba(54, 162, 235,0.5)',
                    borderColor: 'rgb(54, 162, 235)',
                    spanGaps: true,
                    data:$ejecutado
                }]
            }";

            $view = view('presentacion.slide_curvas', compact('cronograma','chartData'));
        }
        else{

            if($cronograma->isEmpty()){
                $view = $this->create($request);
            }
            else{
                $pry = Proyecto::find($pyId);
                $resumen = Presupuesto::where('preProject',$pyId)->get();

                $view = view('formularios.editar_programacion', compact('cronograma','pry','resumen'));

            }
        }

        return $view;
    }

    public function show_con_morris(Request $request, $curva)
    {
        $pyId = $request->pyId;
        $cronograma = Progfisica::where('prgProject',$pyId)->orderBy('prgNumberVal','asc')->get();

        if($curva == '1'){
            $data = '';

            foreach ($cronograma as $i => $crono) {

                $programado = $crono->prgAggregate * 100;
                $ejecutado = $crono->prgAggregateExec;
                if(is_null($ejecutado)){
                    $ejecutado = 0;
                }
                else{
                    $ejecutado = $ejecutado * 100;
                }

                $data .= "{ periodo: '" . $crono->prgPeriodo . "', programado: " . $programado . ", ejecutado: " . $ejecutado . "}, ";


            }
            $data = substr($data, 0, -2);

            $view = view('presentacion.slide_curvas', compact('cronograma','data'));
        }
        else{

            if($cronograma->isEmpty()){
                $view = $this->create($request);
            }
            else{
                $pry = Proyecto::find($pyId);
                $resumen = Presupuesto::where('preProject',$pyId)->get();

                $view = view('formularios.editar_programacion', compact('cronograma','pry','resumen'));

            }
        }

        return $view;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pyId = $request->hnpyId;

        try{

            $exception = DB::transaction(function() use($request){
                $pyId = $request->hnpyId;
                foreach ($request->hnvalId as $i => $val) {
                    
                    if($val != 0){

                        $cronograma = Progfisica::find($val);
                        $cronograma->prgPeriodo = $request->nvalPeriod[$i];
                        $cronograma->prgMount = floatval(str_replace(',', '', $request->nvalMount[$i]));
                        $cronograma->prgPercent = floatval($request->nvalPrcnt[$i]) / 100;
                        $cronograma->prgAggregate = floatval($request->nvalAggrt[$i]) / 100;
                        $cronograma->prgEditNote = $request->nvalNote[$i];
                        $cronograma->save();

                        unset($cronograma);

                    }
                    else{
                        $periodo = new Progfisica();
                        $periodo->prgProject = $pyId;
                        $periodo->prgNumberVal = $request->nvalNumber[$i];
                        $periodo->prgPeriodo = $request->nvalPeriod[$i];
                        $periodo->prgMount = floatval(str_replace(',', '', $request->nvalMount[$i]));
                        $periodo->prgPercent = floatval($request->nvalPrcnt[$i]) / 100;
                        $periodo->prgAggregate = floatval($request->nvalAggrt[$i]) / 100;
                        $periodo->prgEditNote = $request->nvalNote[$i];
                        $periodo->save();

                        unset($periodo);
                    }

                }

            });

            if(is_null($exception)){
                $msg = 'Cronograma calendarizado actualizado correctamente';
                $msgId = 200;
                $url = url('ver/programacion/0');
            }

        }catch(Exception $e){
            $msg = "Error: " . $e->getMessage();
            $msgId = 500;
            $url = '';
        }

        return response()->json(compact('msg','msgId','url','pyId'));
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

    public function verify(Request $request)
    {
        $pyId = $request->pyId;
        $prgFisico = Progfisica::where('prgProject',$pyId)->count();
        $msgId = 0;

        if($prgFisico == 0){
            $msgId = 0;
        }
        else{
            $msgId = 1;
        }

        return $msgId;
    }

    public function indexCurva()
    {
        $pys = Proyecto::where('pryInvalidate',false)->get();

        $view = view('gestion.panel_curvas', compact('pys'));

        return $view;
    }
}
