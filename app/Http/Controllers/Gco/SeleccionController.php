<?php

namespace App\Http\Controllers\Gco;

use App\Models\Seleccion;
use App\Models\Proyecto;
use App\Models\Postor;
use App\Models\Condicionpostor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Exception;
use File;

class SeleccionController extends Controller
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
            if($request->hnpyId == null){
                throw new Exception("Primero debe registrar los datos del proyecto");
            }
            else{
                $proyecto = Proyecto::find($request->hnpyId);
            }

            $proceso = new Seleccion();

            $exception = DB::transaction(function() use($request, &$proceso){

                if($request->hasFile('npcFileSeace')){
                    $file = $request->file('npcFileSeace');
                    $path_parts = pathinfo($_FILES['npcFileSeace']['name']);
                    $filename = $path_parts['filename'];
                    $fileext = $path_parts['extension'];

                    $path_saved = $file->storeAs('docsobras',$filename . '_' . time() . '.' . $fileext);

                    if(!Storage::disk('public')->exists($path_saved))
                        throw new Exception("El archivo no se ha almacenado correctamente.");
                }
                else{
                    $path_saved = null;
                }

                $pyId = $request->hnpyId;

                $proceso->pslProject = $pyId;
                $proceso->pslNomenclatura = $request->npcNom;
                $proceso->pslIdentify = $request->npcSeace;
                $proceso->pslPathFile = $path_saved;
                $proceso->save();

                foreach($request->npsId as $i => $pst){
                    if($i != 0){ // no trabaja la primera fila porque es la fila que sirve para clonar
                        $postor = new Postor();
                        $postor->pstSelectionProc = $proceso->pslId;
                        $postor->pstJpersona = $pst;
                        $postor->pstCondition = $request->npsCondition[$i];
                        $postor->pstPersonType = 'PJ';
                        $postor->save();
                    }
                }
            });

            if(is_null($exception)){
                $msgId = 200;
                $msg = 'Proceso de seleccion registrado correctamente';
                $url = url('proyecto');
                $postores = Postor::with('individualData')->where('pstSelectionProc',$proceso->pslId)->get();
            }
            else{
                throw new Exception($exception);
            }
        }catch(Exceptin $e){
            $msg = 'Error: ' . $e->getMessage() . ' -- ' . $e->getFile() . ' - ' . $e->getLine() . " \n";
            $msgId = 500;
            $url = '';
            $postores = collect(['Sin Postores']);
        }

        return response()->json(compact('msg','msgId','url','proyecto','postores'));
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

                if($request->hasFile('npcFileSeace')){
                    $file = $request->file('npcFileSeace');
                    $path_parts = pathinfo($_FILES['npcFileSeace']['name']);
                    $filename = $path_parts['filename'];
                    $fileext = $path_parts['extension'];

                    $path_saved = $file->storeAs('docsobras',$filename . '_' . time() . '.' . $fileext);

                    if(!Storage::disk('public')->exists($path_saved))
                        throw new Exception("El archivo no se ha almacenado correctamente.");
                }
                else{
                    $path_saved = null;
                }

                $seleccion = Seleccion::find($request->nslId);
                $seleccion->pslNomenclatura = $request->npcNom;
                $seleccion->pslIdentify = $request->npcSeace;
                if(!is_null($path_saved))
                    $seleccion->pslPathFile = $path_saved;
                $seleccion->save();

                foreach($request->npsIdPrs as $i => $pst){
                    if($i != 0){ // no trabaja la primera fila porque es la fila que sirve para clonar
                        $postor = new Postor();
                        $postor->pstSelectionProc = $seleccion->pslId;
                        $postor->pstJpersona = $pst;
                        $postor->pstCondition = $request->npsCondition[$i];
                        $postor->pstPersonType = 'PJ';
                        $postor->save();
                    }
                }
            });

            if(is_null($exception)){
                $msgId = 200;
                $msg = 'Los datos del Proceso de Selección se actualizaron correctamente';
                $pyId = $request->snpyId;
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
