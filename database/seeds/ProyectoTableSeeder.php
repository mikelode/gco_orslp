<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyectoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gcoproyecto')->insert([
    		'prySnip' => '133282',
    		'pryDenomination' => 'MEJORAMIENTO DE LA CARRETERA ARAPA - CHUPA (PU114) - DV HUANCANE (EMP PE 34H), PROVINCIA DE AZANGARO Y HUANCANE - PUNO',
    		'pryViabilityDateSD' => '2017-6-18',
    		'pryViabilityResolution' => 'RGR N° 236-2017-GGR-GR PUNO',
    		'pryExeMode' => 'CONTRATA',
    		'pryExeUnit' => 1,
        ]);
    }
}
