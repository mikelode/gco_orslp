<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sistema extends Model
{
    protected $table = 'gcosistema';
    protected $primaryKey = 'tsysId';
    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany('App\Models\Rol','trolIdSyst','tsysId');
    }
}
