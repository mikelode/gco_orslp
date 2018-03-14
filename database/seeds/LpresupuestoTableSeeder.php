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
	        	'lprDescriptionItem' => 'Costo Directo',
	        	'lprIsProportion' => 0
	        ],[
	        	'lprCodeItem' => 'GG',
	        	'lprOrderItem' => 2,
	        	'lprDescriptionItem' => 'Gastos Generales',
	        	'lprIsProportion' => 1
	        ],[
	        	'lprCodeItem' => 'GGF',
	        	'lprOrderItem' => 3,
	        	'lprDescriptionItem' => 'G.G. Fijos',
	        	'lprIsProportion' => 1
	        ],[
	        	'lprCodeItem' => 'GGV',
	        	'lprOrderItem' => 4,
	        	'lprDescriptionItem' => 'G.G. Variables',
	        	'lprIsProportion' => 1
	        ],[
	        	'lprCodeItem' => 'U',
	        	'lprOrderItem' => 5,
	        	'lprDescriptionItem' => 'Utilidad',
	        	'lprIsProportion' => 1
	        ],[
	        	'lprCodeItem' => 'ST',
	        	'lprOrderItem' => 6,
	        	'lprDescriptionItem' => 'Presup. sin IGV',
	        	'lprIsProportion' => 0
	        ],[
	        	'lprCodeItem' => 'STFR',
	        	'lprOrderItem' => 7,
	        	'lprDescriptionItem' => 'Pto con F.R.',
	        	'lprIsProportion' => 1
	        ],[
	        	'lprCodeItem' => 'IGV',
	        	'lprOrderItem' => 8,
	        	'lprDescriptionItem' => 'IGV',
	        	'lprIsProportion' => 1
	        ],[
	        	'lprCodeItem' => 'PT',
	        	'lprOrderItem' => 9,
	        	'lprDescriptionItem' => 'Presupuesto Total',
	        	'lprIsProportion' => 0
	        ]
    	]);
    }
}
