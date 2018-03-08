<?php
namespace App\Traits;

use App\Models\Persona;

trait BusquedaTablas{
	public function exist_persona($dni)
    {
        $persona = Persona::where('perDni',$dni)->first();

        if(count($persona) == 0)
        {
            $msg = 'El DNI ingresado no está registrado';
            $msgId = 0;
        }
        else
        {
            $msg = 'El DNI ingresado ya esta registrado';
            $msgId = 1;
        }

        return response()->json(compact('msg','msgId','persona'));
    }
}