<?php

use Illuminate\Database\Seeder;

class EquiprofTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Equiprof::class, 3)->create();
    }
}
