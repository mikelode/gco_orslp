<?php

namespace App\Http\Controllers\Gco;

use App\Models\Proyecto;
use App\Models\Presupuesto;
use App\Models\Partida;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;
use Excel;
use File;

class PresupuestoController extends Controller
{
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
                    ->where('pryId',$pyAccess)
                    ->get();
        }

        
        /*$pto = Presupuesto::select('*')
                ->join('gcoproyecto','pryId','=','preProject')
                ->where('pryInvalidate',false)
                ->where('preProject',1)->get();
                
        $ptd = Partida::where('parProject',1)->get();*/
        $view = view('gestion.panel_presupuesto',compact('pys'));
        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pyId = $request->hnpyId;
        try{
            $exception = DB::transaction(function() use($request){

                foreach ($request->nptoOrder as $i => $item) {
                    $presupuesto = new Presupuesto();
                    $presupuesto->preProject = $request->hnpyId;
                    $presupuesto->preOrder = $item;
                    $presupuesto->preCodeItem = $request->nptoCodeItem[$i];
                    $presupuesto->preItemGeneral = $request->nptoItemGral[$i];
                    $presupuesto->preItemGeneralPrcnt = $request->nptoItemPercent[$i] / 100;
                    $presupuesto->preItemGeneralMount = floatval(str_replace(',', '', $request->nptoItemMount[$i]));
                    $presupuesto->save();
                    unset($presupuesto);
                }

            });

            if(is_null($exception)){
                $msg = 'Presupuesto General Resumen ha sido registrado con éxito';
                $msgId = 200;
                $url = url('ver/presupuesto');
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

        return response()->json(compact('msg','msgId','url','pyId'));
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

        $pry = Proyecto::find($pyId);
        $pto = Presupuesto::where('preProject',$pyId)->get();

        $sinPto = $pto->isEmpty();

        if($sinPto){
            $view = view('formularios.nuevo_presupuesto',compact('pry'));
        }
        else{
            $ptd = Partida::where('parProject',$pyId)->get();
            $view = view('formularios.editar_presupuesto',compact('pry','pto','ptd'));
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

                foreach ($request->nptoId as $i => $ptoId) {
                
                    $presupuesto = Presupuesto::find($ptoId);
                    $presupuesto->preItemGeneralPrcnt = $request->nptoItemPercent[$i] / 100;
                    $presupuesto->preItemGeneralMount = floatval(str_replace(',', '', $request->nptoItemMount[$i]));
                    $presupuesto->save();

                    unset($presupuesto);
                }

            });

            if(is_null($exception)){
                $msg = 'Cambiados almacenados correctamente';
                $msgId = 200;
                $url = 'ver/presupuesto';
            }
            else{
                throw new Exception($exception);
            }

        }catch(Exception $e){
            $msg = 'Error: ' . $e->getMessage() . ' -Archivo- ' . $e->getFile() . ' -Linea- ' . $e->getLine() . " \n";
            $msgId = 500;
            $url= '';
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

    public function getMontoItemResumen(Request $request)
    {
        $keyId = explode('-', $request->ptoId) ;
        $preId = $keyId[0];
        $itemCode = $keyId[1];

        $ptoResumen = Presupuesto::find($preId);

        return $ptoResumen->preItemGeneralMount;

    }
}
