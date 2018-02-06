<?php

namespace App\Http\Controllers\Gco;

use App\Models\Proyecto;
use App\Models\Presupuesto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        $pys = Proyecto::all();
        $pto = Presupuesto::where('preProject',1)->get();
        $view = view('gestion.panel_presupuesto',compact('pys','pto'));
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
        //
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
    public function update(Request $request, $id)
    {
        //
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
        $pto = Presupuesto::where('preProject',$request->pyId)->get();
        return response()->json(compact('pto'));
    }

    public function importXls(Request $request)
    {
        try{

            $pyId = $request->hnimpPry;

            if($request->hasFile('nimpFile')){
                $file = $request->file('nimpFile');
                $extension = File::extension($file->getClientOriginalName());

                if($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv'){
                    $path = $file->getRealPath();
                    $partidas = Excel::load($path, function($reader){})->get();

                    if(!empty($partidas) && count($partidas)){

                        foreach ($partidas as $key => $value) {

                            $div = explode('.', $value->item);
                            $nivel = count($div);

                            $insert[] = [
                                'preProject' => $pyId,
                                'preLevel' => $nivel,
                                'preItem' => trim($value->item),
                                'preDescription' => trim($value->descripcion),
                                'preUnit' => trim($value->unidad),
                                'preMetered' => $value->metrado,
                                'prePrice' => $value->precio,
                                'prePartial' => $value->parcial,
                            ];
                        }

                        if(!empty($insert)){
                            
                            $insertBudget = DB::table('gcopresupuesto')->insert($insert);
                            
                            if($insertBudget){
                                $msg = 'Presupuesto importado correctamente';
                                $msgId = 200;
                            }
                            else{
                                throw new Exception("Error al intentar insetar los datos a la BD");
                            }
                                
                        }
                        else{
                            throw new Exception("No se pudo relacionar los campos de la base de datos con los campos de la hoja excel");
                        }
                    }
                    else{
                        throw new Exception("No se pudo leer los datos del archivo excel seleccionado");
                    }
                }
                else{
                    throw new Exception("El archivo seleccionado debe tener la extension .xls | .xlsx o .csv");
                }
            }
            else{
                throw new Exception("No se ha seleccionado ningún archivo para su procesamiento");   
            }

        }catch(Exception $e){
            $msg = 'Error: ' . $e->getMessage() . ' -- ' . $e->getFile() . ' - ' . $e->getLine() . " \n";
            $msgId = 500;
        }
        
        return response()->json(compact('msgId','msg'));
    }
}