<?php

namespace App\Http\Controllers\Gco;

use App\Models\Jpersona;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Traits\BusquedaTablas;

class JpersonaController extends Controller
{
    use BusquedaTablas;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contrat = Jpersona::all();

        $view = view('gestion.panel_personaj', compact('contrat'));
        
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
        try{

            if($this->exist_persona($request->nprjNumdoc, 'juridica')->getData()->msgId == 1){
                $persona = Jpersona::where('prjRegistNumber',$request->nprjNumdoc)->first();
                $msg = 'Persona jurídica ya fue registrada anteriormente';
                $msgId = '200';
            }
            else{
                $persona = new Jpersona();

                $exception = DB::transaction(function() use($request, &$persona){

                    $persona->prjRegistType = $request->nprjTipodoc;
                    $persona->prjRegistNumber = $request->nprjNumdoc;
                    $persona->prjBusiName = $request->nprjDenom;
                    $persona->prjAcronym = $request->nprjSigla;
                    $persona->prjLegalRepDni = $request->nprjRepdni;
                    $persona->prjLegalRepName = $request->nprjRepname;
                    $persona->prjLegalRepPaterno = $request->nprjReppat;
                    $persona->prjLegalRepMaterno = $request->nprjRepmat;
                    $persona->prjEaddress = $request->nprjEdir;
                    $persona->prjPaddress = $request->nprjFdir;
                    $persona->save();
                });

                if(is_null($exception)){
                    $msg = 'Persona jurídica registrada correctamente';
                    $msgId = '200';
                    $url = url('tablas/jpersona');
                }
                else{
                    throw new Exception($exception);
                }
            }

        }catch(Exception $e){
            $msg = 'Error: ' . $e->getMessage() . ' -- ' . $e->getFile() . ' - ' . $e->getLine() . " \n";
            $msgId = 500;
            $url = '';
        }

        return response()->json(compact('msgId','msg','persona','url'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Jpersona::where('prjRegistNumber',$id)->first();
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
}
