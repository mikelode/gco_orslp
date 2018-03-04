<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('gcousuario')->insert(array(
            'tusNickName' => 'admin',
            'password' => \Hash::make('obras'),
            'tusDni' => '00000000',
            'tusFullName' => 'Usuario Administrador del Sistema',
            'tusNames' => 'ADMINISTRADOR',
            'tusPaterno' => 'Administrador',
            'tusMaterno' => 'Sistema',
            'tusRole' => 'admin',
            'tusProject' => 0,
            'tusRegisterBy'=> 'admin',
            'tusState'=> true,
        ));
    }
}
