<?php

namespace App\Http\Controllers\Gco;

use App\Models\Proyecto;
use App\Models\Presupuesto;
use App\Models\Listpresupuesto;
use App\Models\Itempresupuesto;
use App\Models\Tipopresupuesto;
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

    public function createPrestacion(Request $request)
    {
        $ptoIniId = $request->ipto;

        $items = Presupuesto::find($ptoIniId)->items;
        $pto = Presupuesto::find($ptoIniId);
        $ptoTipo = Tipopresupuesto::where('tprId','!=',1)->get(); // los tipos que no sean inicial

        $view = view('formularios.nuevo_prestacion', compact('items','ptoTipo','pto'));

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
        $pyId = $request->hnpyId;
        try{
            $exception = DB::transaction(function() use($request){

                $presupuesto = new Presupuesto();
                $presupuesto->preProject = $request->hnpyId;
                $presupuesto->preType = 1;
                $presupuesto->preName = 'Expediente';
                $presupuesto->save();

                foreach ($request->nptoItemGral as $i => $item) {
                    if($i != 0){

                        $itemList = Listpresupuesto::find($item);

                        $itemPto = new Itempresupuesto();
                        
                        $itemPto->iprBudget = $presupuesto->preId;
                        $itemPto->iprOrder = $itemList->lprOrderItem;
                        $itemPto->iprCodeItem = $itemList->lprCodeItem;
                        $itemPto->iprItemGeneral = $itemList->lprDescriptionItem;
                        if($itemList->lprIsProportion)
                            $itemPto->iprItemGeneralPrcnt = $request->nptoItemPercent[$i];// / 100;
                        $itemPto->iprItemGeneralMount = floatval(str_replace(',', '', $request->nptoItemMount[$i]));
                        $itemPto->save();
                        unset($itemPto);
                    }
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

    public function storePrestacion(Request $request)
    {
        $pyId = $request->hnpryId;
        
        try{
            $exception = DB::transaction(function() use($request){

                $presupuesto = new Presupuesto();
                $presupuesto->preProject = $request->hnpryId;
                $presupuesto->preType = $request->nptoTipo;
                $presupuesto->preNote = $request->nptoNote;
                $presupuesto->preName = $request->nptoDescPrest;
                $presupuesto->save();

                foreach ($request->niprCode as $i => $item) {
                        $itemPto = new Itempresupuesto();
                        
                        $itemPto->iprBudget = $presupuesto->preId;
                        $itemPto->iprOrder = $request->hniprOrder[$i];
                        $itemPto->iprCodeItem = $item;
                        $itemPto->iprItemGeneral = $request->niprGnrl[$i];
                        $itemPto->iprItemGeneralPrcnt = $request->niprPrcnt[$i];
                        $itemPto->iprItemGeneralMount = floatval(str_replace(',', '', $request->niprMountPrest[$i]));
                        $itemPto->save();
                        unset($itemPto);
                }
            });

            if(is_null($exception)){
                $msg = 'Los montos de la prestación han sido registrados con éxito';
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
        $pto = Presupuesto::select(DB::raw("*, fnItemsGetDescription(preType) as itemDsc"))->with('items')->where('preProject',$pyId)->get();
        $listPto = Listpresupuesto::all();

        $sinPto = $pto->isEmpty();

        if($sinPto){
            $view = view('formularios.nuevo_presupuesto',compact('pry','listPto'));
        }
        else{

            $totalPtos = collect();
            
            foreach($pto as $p){

                if($p->preType == 4){ // si se trata de un presupuesto deductivo
                    $ptoDeducible = $p->items;
                    $deductivo = $ptoDeducible->map(function($ptoDeducible){
                        $ptoDeducible->iprItemGeneralMount = $ptoDeducible->iprItemGeneralMount * -1;
                        return $ptoDeducible;
                    });

                    $totalPtos = $totalPtos->merge($deductivo);
                } 
                else{
                    $totalPtos = $totalPtos->merge($p->items);
                }
            }

            $itemGroup = $totalPtos->groupBy('iprCodeItem');

            $ptoFinal = $itemGroup->map(function($it,$k){
                return $it->sum('iprItemGeneralMount');
            });

            $ptd = Partida::where('parProject',$pyId)->get();
            $view = view('formularios.editar_presupuesto',compact('pry','pto','ptd','listPto','ptoFinal'));
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

        $pto = Presupuesto::find($request->hnptoId[0]);
        $pyId = $pto->preProject;

        try{
            $exception = DB::transaction(function() use($request){

                $pto = Presupuesto::find($request->hnptoId[0]);
                $pto->preNote = $request->nptoNote;
                $pto->save();


                foreach ($request->nptoItemId as $i => $itemId) {

                    $itemList = Listpresupuesto::find($itemId);
                
                    $presupItem = Itempresupuesto::find($itemId);
                    /*if($itemList->lprIsProportion)
                            $presupItem->iprItemGeneralPrcnt = $request->nptoItemPercent[$i];// / 100;*/
                    $presupItem->iprItemGeneralMount = floatval(str_replace(',', '', $request->nptoItemMount[$i]));
                    $presupItem->save();

                    unset($presupItem);
                }

            });

            if(is_null($exception)){
                $msg = 'Cambios almacenados correctamente';
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

    public function update1(Request $request) // funcion para actualizar de golpe los presupuesto modificados fue cambiando a row by row
    {
        $pyId = $request->hnpyId;

        try{
            $exception = DB::transaction(function() use($request){

                foreach ($request->nptoItemId as $i => $itemId) {

                    $itemList = Listpresupuesto::find($itemId);
                
                    $presupItem = Itempresupuesto::find($itemId);
                    if($itemList->lprIsProportion)
                            $presupItem->iprItemGeneralPrcnt = $request->nptoItemPercent[$i];// / 100;
                    $presupItem->iprItemGeneralMount = floatval(str_replace(',', '', $request->nptoItemMount[$i]));
                    $presupItem->save();

                    unset($presupItem);
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
        $keyId = explode('-', $request->itemId) ;
        $itemId = $keyId[0];
        $itemCode = $keyId[1];

        //$ptoResumen = Presupuesto::find($preId);
        $ptoResumen = Itempresupuesto::find($itemId);

        return $ptoResumen->iprItemGeneralMount;

    }

    public function list(Request $request)
    {
        $pyId = $request->pyId;

        $presupuestoPy = Presupuesto::where('preProject',$pyId)->get();

        $optionHtml = '<option value="NA"> Elija un presupuesto </option>';

        foreach($presupuestoPy as $pto){
            $optionHtml .= '<option value="' . $pto->preId . '">' . $pto->preType . ' - ' . $pto->preName .'</option>';
        }

        return response()->json(compact('presupuestoPy','optionHtml'));
    }
}
