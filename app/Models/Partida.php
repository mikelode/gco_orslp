<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $table = 'gcopartidas';
    protected $primaryKey = 'parId';
    public $timestamps = false;
}
