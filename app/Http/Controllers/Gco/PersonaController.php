<?php

namespace App\Http\Controllers\Gco;

use App\Models\Persona;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Traits\BusquedaTablas;

class PersonaController extends Controller
{
    use BusquedaTablas;
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

            if($this->exist_persona($request->nprsDni)->getData()->msgId == 1){
                $persona = Persona::where('perDni',$request->nprsDni)->first();
                $msg = 'Persona registrada anteriormente';
                $msgId = '200';
            }
            else{
                $exception = DB::transaction(function() use($request){

                    $persona = new Persona();

                    $persona->perDni = $request->nprsDni;
                    $persona->perFullName = $request->nprsOcup.' '.$request->nprsNames.' '.$request->nprsPaterno.' '.$request->nprsMaterno;
                    $persona->perNames = $request->nprsNames;
                    $persona->perPaterno = $request->nprsPaterno;
                    $persona->perMaterno = $request->nprsMaterno;
                    $persona->perOcupation = $request->nprsOcup;
                    $persona->perBirthday = $request->nprsBirthday;
                    $persona->perEmail = $request->nprsEmail;
                    $persona->perPhone1 = $request->nprsPhone;

                    $persona->save();

                });

                if(is_null($exception)){
                    $msg = 'Persona registrada correctamente';
                    $msgId = '200';
                }
                else{
                    throw new Exception($exception);
                }
            }

        }catch(Exception $e){
            $msg = 'Error: ' . $e->getMessage() . ' -- ' . $e->getFile() . ' - ' . $e->getLine() . " \n";
            $msgId = 500;
        }

        return response()->json(compact('msgId','msg','persona'));
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

    public function exist(Request $request)
    {
        return $this->exist_persona($request->dni);
        /*$persona = Persona::where('perDni',$request->dni)->first();

        if($persona->count() == 0)
        {
            $msg = 'El DNI ingreso no está registrado';
            $msgId = 0;
        }
        else
        {
            $msg = 'El DNI ingresado ya esta registrado';
            $msgId = 1;
        }

        return response()->json(compact('msg','msgId','persona'));*/
    }
}
