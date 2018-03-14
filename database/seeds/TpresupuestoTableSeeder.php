<?php

use Illuminate\Database\Seeder;

class TpresupuestoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gcotpresupuesto')->insert([
        	[
        		'tprDescription' => 'Inicial',
        		'tprHaveValorization' => 1
        	],[
        		'tprDescription' => 'Adicional',
        		'tprHaveValorization' => 1
        	],[
        		'tprDescription' => 'Mayores Metrados',
        		'tprHaveValorization' => 0
        	],[
        		'tprDescription' => 'Deductivo',
        		'tprHaveValorization' => 0
        	]
    	]);
    }
}
