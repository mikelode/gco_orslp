<?php

namespace App\Http\Controllers\Gco;

use App\Models\Seleccion;
use App\Models\Proyecto;
use App\Models\Postor;
use App\Models\Condicionpostor;
use App\Models\Uejecutora;
use App\Models\Equiprof;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Exception;

class EjecucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try{

            if($request->henpyId == null){
                throw new Exception("ERROR: Primero debe registrar los datos del proyecto");
            }
            else{
                $proyecto = Proyecto::find($request->henpyId);
            }

            if($request->nejePostor == null){
                //throw new Exception("ERROR: Primero debe registrar los datos de los postores del proceso de selección");
            }
            else{
                $postores = Postor::find($request->nejePostor);
            }

            $ejecucion = new Uejecutora();

            $exception = DB::transaction(function() use($request, &$ejecucion){

                $ejecucion->ejePostor = $request->nejePostor;
                $ejecucion->ejeProject = $request->henpyId;
                $ejecucion->ejeMode = $request->nejeMod;
                $ejecucion->ejeSisContract = $request->nejeContract;
                $ejecucion->ejeMountContract = $request->nejeMountContract;
                $ejecucion->ejeMountRefValue = $request->nejeMountRefValue;
                $ejecucion->ejeRelationFactor = $request->nejeRelFactor;
                $ejecucion->ejeDateAgree = $request->nejeDateAgree;
                $ejecucion->ejeMonthTerm = $request->nejeMonthTerm;
                $ejecucion->ejeDaysTerm = $request->nejeDaysTerm;
                $ejecucion->ejeStartDate = $request->nejeStartDate;
                $ejecucion->ejeEndDate = $request->nejeEndDate;
                $ejecucion->save();

                foreach($request->nteamId as $i => $pers){
                    if($i != 0){ // no trabaja la primera fila porque es la fila que sirve para clonar
                        $team = new Equiprof();
                        $team->prfPerson = $pers;
                        $team->prfJob = $request->nteamJob[$i];
                        $team->prfUejecutora = $ejecucion->ejeId;
                        $team->save();
                    }
                }

            });

            if(is_null($exception)){
                $msgId = 200;
                $msg = 'Datos de la ejecución registrados correctamente';
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        try{
            $exception = DB::transaction(function() use($request){

                $ejecucion = Uejecutora::find($request->henejeId);
                $ejecucion->ejeMode = $request->nejeMod;
                $ejecucion->ejeSisContract = $request->nejeContract;
                $ejecucion->ejeMountContract = $request->nejeMountContract;
                $ejecucion->ejeMountRefValue = $request->nejeMountRefValue;
                $ejecucion->ejeRelationFactor = $request->nejeRelFactor;
                $ejecucion->ejeDateAgree = $request->nejeDateAgree;
                $ejecucion->ejeMonthTerm = $request->nejeMonthTerm;
                $ejecucion->ejeDaysTerm = $request->nejeDaysTerm;
                $ejecucion->ejeStartDate = $request->nejeStartDate;
                $ejecucion->ejeEndDate = $request->nejeEndDate;
                $ejecucion->save();

                foreach($request->nteamId as $i => $pers){
                    if($i != 0){ // no trabaja la primera fila porque es la fila que sirve para clonar
                        $team = new Equiprof();
                        $team->prfPerson = $pers;
                        $team->prfJob = $request->nteamJob[$i];
                        $team->prfUejecutora = $ejecucion->ejeId;
                        $team->save();
                    }
                }

            });

            if(is_null($exception)){
                $msgId = 200;
                $msg = 'Los datos de Ejecución del proyecto se actualizaron correctamente';
                $pyId = $request->henpyId;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
