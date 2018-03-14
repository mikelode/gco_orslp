<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipopresupuesto extends Model
{
    protected $table = 'gcotpresupuesto';
    protected $primaryKey = 'tprId';
    public $timestamps = false;
}
