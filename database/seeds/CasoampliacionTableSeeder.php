<?php

use Illuminate\Database\Seeder;

class CasoampliacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gcocasoampliacion')->insert([
            [
                'camDescription' => 'Cuando se aprueba el adicional, siempre y cuando afecte el plazo. En este caso, el contratista amplía el plazo de las garantías que hubiera otorgado',
                'camShortDesc' => 'Por aprobación de adicional'
            ],[
                'camDescription' => 'Por atrazos y/o paralizaciones no imputables al contratista',
                'camShortDesc' => 'Por atrazos y/o paralizaciones'
            ]
        ]);
    }
}
