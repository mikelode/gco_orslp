<?php

namespace App\Http\Controllers\Gco;

use App\Models\Proyecto;
use App\Models\Presupuesto;
use App\Models\Partida;
use App\Models\Avance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;
use Excel;
use File;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PartidaController extends Controller
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
    public function update(Request $request)
    {
        try{

            $exception = DB::transaction(function() use($request){

                $partida = Partida::find($request->parId);
                $partida->parUnit = $request->parUnit;
                $partida->parMetered = $request->parMetered;
                $partida->parPrice = $request->parPrice;
                $partida->parPartial = $request->parPartial;
                $partida->save();

            });

            if(is_null($exception)){
                $msg = 'Partida actualizada correctamente';
                $msgId = 200;
            }

        }catch(Exception $e){
            $msg = "Error: " . $e->getMessage();
            $msgId = 500;
        }

        return response()->json(compact('msg','msgId'));
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
        $ptd = Partida::where('parProject',$request->pyId)->get();
        return response()->json(compact('ptd'));
    }

    public function importXls(Request $request)
    {
        try{

            $pyId = $request->hnimpPry;
            $url = url('ver/presupuesto');

            if($request->hnimpAction == 'clear'){
                $avance = Avance::where('aprProject',$pyId)->get();
                
                if(!$avance->isEmpty())
                    throw new Exception("Las partidas presupuestarias presentan registros de avance o valorizaciones por lo que no es posible realizar esta acción");
                
                $limpiarPartidas = Partida::where('parProject',$pyId)->delete();
            }

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
                                'parProject' => $pyId,
                                'parLevel' => $nivel,
                                'parItem' => trim($value->item),
                                'parDescription' => $value->descripcion,
                                'parUnit' => trim($value->unidad),
                                'parMetered' => $value->metrado,
                                'parPrice' => $value->precio,
                                'parPartial' => $value->parcial,
                            ];
                        }

                        if(!empty($insert)){
                            
                            $insertBudget = DB::table('gcopartidas')->insert($insert);
                            
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
        
        return response()->json(compact('msgId','msg','pyId','url'));
    }

    public function importCsv(Request $request)
    {
        try{

            $pyId = $request->hnimpPry;
            $url = url('ver/presupuesto');

            if($request->hnimpAction == 'clear'){
                $avance = Avance::where('aprProject',$pyId)->get();
                
                if(!$avance->isEmpty())
                    throw new Exception("Las partidas presupuestarias presentan registros de avance o valorizaciones por lo que no es posible realizar esta acción");
                
                $limpiarPartidas = Partida::where('parProject',$pyId)->delete();
            }

            if($request->hasFile('nimpFile')){
                $file = $request->file('nimpFile');
                $extension = File::extension($file->getClientOriginalName());

                if($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv'){
                    $path = $file->getRealPath();
                    $partidas = Excel::load($path, function($reader){}, 'ISO-8859-1')->get();

                    if(!empty($partidas) && count($partidas)){

                        foreach ($partidas as $key => $value) {

                            $div = explode('.', $value->item);
                            $nivel = count($div);

                            $insert[] = [
                                'parProject' => $pyId,
                                'parLevel' => $nivel,
                                'parItem' => trim($value->item),
                                'parDescription' => $value->descripcion,
                                'parUnit' => trim($value->unidad),
                                'parMetered' => $value->metrado,
                                'parPrice' => $value->precio,
                                'parPartial' => $value->parcial,
                            ];
                        }

                        if(!empty($insert)){
                            
                            $insertBudget = DB::table('gcopartidas')->insert($insert);
                            
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
        
        return response()->json(compact('msgId','msg','pyId','url'));
    }

    public function importExcel(Request $request)
    {
        try{

            $pyId = $request->hnimpPry;
            $url = url('ver/presupuesto');

            if($request->hnimpAction == 'clear'){
                $avance = Avance::where('aprProject',$pyId)->get();
                
                if(!$avance->isEmpty())
                    throw new Exception("Las partidas presupuestarias presentan registros de avance o valorizaciones por lo que no es posible realizar esta acción");
                
                $limpiarPartidas = Partida::where('parProject',$pyId)->delete();
            }

            if($request->hasFile('nimpFile')){
                $file = $request->file('nimpFile');
                $extension = File::extension($file->getClientOriginalName());

                if($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv'){
                    $path = $file->getRealPath();
                    $partidas = IOFactory::load($path, function($reader){}, 'ISO-8859-1');
                    $partidas = $partidas->getActiveSheet()->toArray(null, true, true, true);
                    $headerXls = array_shift($partidas);
                    $headerPar = array('A' => 'item', 'B' => 'descripcion', 'C' => 'unidad', 'D' => 'metrado', 'E' => 'precio', 'F' => 'parcial');

                    if($headerXls != $headerPar){
                        throw new Exception("Revise que la primera fila de su archivo excel tenga el siguiente orden de las columnas:\n| item | descripcion | unidad | metrado | precio | parcial |");
                    }

                    if(!empty($partidas) && count($partidas)){
                        foreach ($partidas as $key => $value) {
                            $div = explode('.', $value['A']);
                            $nivel = count($div);

                            $insert[] = [
                                'parProject' => $pyId,
                                'parLevel' => $nivel,
                                'parItem' => trim($value['A']),
                                'parDescription' => $value['B'],
                                'parUnit' => trim($value['C']),
                                'parMetered' => floatval(str_replace(',', '', $value['D'])),
                                'parPrice' => floatval(str_replace(',', '', $value['E'])),
                                'parPartial' => floatval(str_replace(',', '', $value['F'])),
                            ];
                        }

                        if(!empty($insert)){
                            
                            $insertBudget = DB::table('gcopartidas')->insert($insert);
                            
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
            $msg = 'Error: ' . $e->getMessage() . ' \n-- ' . $e->getFile() . ' - ' . $e->getLine() . " \n";
            $msgId = 500;
        }
        
        return response()->json(compact('msgId','msg','pyId','url'));
    }
}
