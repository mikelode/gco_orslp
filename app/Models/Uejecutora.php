<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uejecutora extends Model
{
    protected $table = 'gcouejecutora';
    protected $primaryKey = 'ejeId';
    public $timestamps = false;

    public function profesionals()
    {
    	return $this->hasMany('App\Models\Equiprof','prfUejecutora','ejeId');
    }
}
