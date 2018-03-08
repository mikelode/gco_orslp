<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listpresupuesto extends Model
{
    protected $table = 'gcolpresupuesto';
    protected $primaryKey = 'lprId';
    public $timestamps = false;
}
