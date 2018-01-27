<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equiprof extends Model
{
    protected $table = 'gcoEquiprof';
    protected $primaryKey = 'prfId';
    public $timestamps = false;

    public function individualData()
    {
    	return $this->hasOne('App\Models\Persona','perId','prfPerson');	
    }
}
