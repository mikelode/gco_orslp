<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postor extends Model
{
    protected $table = 'gcopspostores';
    protected $primaryKey = 'pstId';
    public $timestamps = false;


    public function individualData(){
        return $this->hasOne('App\Models\Jpersona','prjId','pstJpersona');
    }

}
