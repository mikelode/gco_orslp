<?php
namespace App\Traits;

use App\Models\Persona;
use App\Models\Jpersona;

trait BusquedaTablas{
	public function exist_persona($dni, $tipo)
    {
        if($tipo == 'natural')
            $registros = Persona::where('perDni',$dni)->first();
        else if($tipo == 'juridica')
            $registros = Jpersona::where('prjRegistNumber',$dni)->first();

        if(count($registros) == 0)
        {
            $msg = 'El número de documento ingresado no está registrado';
            $msgId = 0;
        }
        else
        {
            $msg = 'El número de documneto ingresado ya esta registrado';
            $msgId = 1;
        }

        return response()->json(compact('msg','msgId','registros'));
    }

    public function get_status_obra($programado, $ejecutado) /* Los parametros trabajan con los montos presupuestales */
    {
        $performance = round(($ejecutado / $programado) * 100);
        $status = 'Sin estado';
        
        if($performance < 100){
            $status = 'Atrazado';
        }
        else if($performance == 100){
            $status = 'Normal';
        }
        else if($performance > 100){
            $status = 'Adelantado';
        }

        return $status;

    }
}