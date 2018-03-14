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
    		'pryViabilityResolution' => 'RGR N° 236-2017-GGR-GR PUNO',
            'pryDateResolution' => '2017-6-18',
    		'pryExeMode' => 'AI',
            'prySisContract' => 'SA',
    		'pryExeUnit' => 1,
            'pryDateAgree' => '2013-12-23',
            'pryMonthTerm' => 18,
            'pryDaysTerm' => 540,
            'pryStartDateExe' => '2017-12-28',
            'pryEndDateExe' => '2019-6-20',
        ]);
    }
}
