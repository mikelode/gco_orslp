<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'gcoroles';
    protected $primaryKey = 'trolId';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo('App\User','trolIdUser','tusId');
    }

    public function permissions()
    {
        return $this->belongsTo('App\Models\Sistema','trolIdSyst','tsysId');
    }
}
