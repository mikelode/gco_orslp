<?php

use Illuminate\Database\Seeder;

class PresupuestoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gcopresupuesto')->insert([[
    		'preProject' => '1',
            'preOrder' => 1,
            'preCodeItem' => 'CD',
    		'preItemGeneral' => 'COSTO DIRECTO',
    		'preItemGeneralPrcnt' => null,
    		'preItemGeneralMount' => 34427890.2,
        ],[
    		'preProject' => '1',
            'preOrder' => 2,
            'preCodeItem' => 'GG',
    		'preItemGeneral' => 'GASTOS GENERALES',
    		'preItemGeneralPrcnt' => 0.0933,
    		'preItemGeneralMount' => 3212122.16,
        ],[
    		'preProject' => '1',
            'preOrder' => 3,
            'preCodeItem' => 'U',
    		'preItemGeneral' => 'UTILIDAD',
    		'preItemGeneralPrcnt' => 0.08,
    		'preItemGeneralMount' => 2754231.22,
        ],[
    		'preProject' => '1',
            'preOrder' => 4,
            'preCodeItem' => 'ST',
    		'preItemGeneral' => 'SUBTOTAL GENERAL',
    		'preItemGeneralPrcnt' => NULL,
    		'preItemGeneralMount' => 40394243.58,
        ],[
    		'preProject' => '1',
            'preOrder' => 5,
            'preCodeItem' => 'IGV',
    		'preItemGeneral' => 'IGV',
    		'preItemGeneralPrcnt' => 0.18,
    		'preItemGeneralMount' => 7270963.84,
        ],[
    		'preProject' => '1',
            'preOrder' => 6,
            'preCodeItem' => 'PT',
    		'preItemGeneral' => 'PRESUPUESTO TOTAL',
    		'preItemGeneralPrcnt' => null,
    		'preItemGeneralMount' => 47665207.42,
        ]]);
    }
}
