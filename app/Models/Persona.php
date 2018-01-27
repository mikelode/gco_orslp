<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'gcoPersona';
    protected $primaryKey = 'perId';
    public $timestamps = false;
}
