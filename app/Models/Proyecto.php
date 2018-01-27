<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'gcoProyecto';
    protected $primaryKey = 'pryId';
    public $timestamps = false;

    public function ejecutor()
    {
    	return $this->hasMany('App\Models\Uejecutora','ejeId','pryExeUnit');	
    }
}
