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
        //$this->call(PersonaTableSeeder::class);
        //$this->call(UejecutoraTableSeeder::class);
        //$this->call(EquiprofTableSeeder::class);
        //$this->call(ProyectoTableSeeder::class);
        $this->call(TpresupuestoTableSeeder::class);
        //$this->call(PresupuestoTableSeeder::class);
        $this->call(UsuarioTableSeeder::class);
        $this->call(SistemaTableSeeder::class);
        $this->call(LpresupuestoTableSeeder::class);
    }
}
