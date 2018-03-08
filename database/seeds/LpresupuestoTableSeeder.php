<?php

use Illuminate\Database\Seeder;

class LpresupuestoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gcolpresupuesto')->insert([
        	[
	        	'lprCodeItem' => 'CD',
	        	'lprOrderItem' => 1,
	        	'lprDescriptionItem' => 'COSTO DIRECTO',
	        	'lprIsProportion' => 0
	        ],[
	        	'lprCodeItem' => 'GG',
	        	'lprOrderItem' => 2,
	        	'lprDescriptionItem' => 'GASTOS GENERALES',
	        	'lprIsProportion' => 1
	        ],[
	        	'lprCodeItem' => 'GGF',
	        	'lprOrderItem' => 3,
	        	'lprDescriptionItem' => 'GASTOS GENERALES FIJOS',
	        	'lprIsProportion' => 1
	        ],[
	        	'lprCodeItem' => 'GGV',
	        	'lprOrderItem' => 4,
	        	'lprDescriptionItem' => 'GASTOS GENERALES VARIABLES',
	        	'lprIsProportion' => 1
	        ],[
	        	'lprCodeItem' => 'U',
	        	'lprOrderItem' => 5,
	        	'lprDescriptionItem' => 'UTILIDAD',
	        	'lprIsProportion' => 1
	        ],[
	        	'lprCodeItem' => 'ST',
	        	'lprOrderItem' => 6,
	        	'lprDescriptionItem' => 'SUB TOTAL',
	        	'lprIsProportion' => 0
	        ],[
	        	'lprCodeItem' => 'IGV',
	        	'lprOrderItem' => 7,
	        	'lprDescriptionItem' => 'IGV',
	        	'lprIsProportion' => 1
	        ],[
	        	'lprCodeItem' => 'PT',
	        	'lprOrderItem' => 8,
	        	'lprDescriptionItem' => 'PRESUPUESTO TOTAL',
	        	'lprIsProportion' => 0
	        ]
    	]);
    }
}
