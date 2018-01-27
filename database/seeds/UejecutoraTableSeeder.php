<?php

use Illuminate\Database\Seeder;

class UejecutoraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Uejecutora::class, 3)->create();
    }
}
