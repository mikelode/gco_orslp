<?php

use Illuminate\Database\Seeder;

class CondicionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gcopscondicion')->insert([
            [
                'pscDescription' => 'Buena PRO'
            ],[
                'pscDescription' => 'Elegible'
            ],[
                'pscDescription' => 'No Cumple'
            ]
        ]);
    }
}
