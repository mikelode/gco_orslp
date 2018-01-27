<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PersonaTableSeeder::class);
        $this->call(UejecutoraTableSeeder::class);
        $this->call(EquiprofTableSeeder::class);
        $this->call(ProyectoTableSeeder::class);
    }
}
