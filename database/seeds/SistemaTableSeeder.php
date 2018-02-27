<?php

use Illuminate\Database\Seeder;

class SistemaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gcosistema')->insert([[
    		'tsysModulo' => 'proyecto',
    		'tsysFunction' => 'Ver',
    		'tsysDescF' => 'Observar proyectos registrados',
            'tsysVarHandler' => 'pyver',
        ],[
        	'tsysModulo' => 'proyecto',
    		'tsysFunction' => 'Registrar',
    		'tsysDescF' => 'Registrar nuevos proyectos',
            'tsysVarHandler' => 'pyregistrar',
        ],[
        	'tsysModulo' => 'proyecto',
    		'tsysFunction' => 'Editar',
    		'tsysDescF' => 'Editar datos del proyecto',
            'tsysVarHandler' => 'pyeditar',
        ],[
        	'tsysModulo' => 'proyecto',
    		'tsysFunction' => 'Eliminar',
    		'tsysDescF' => 'Eliminar registro de proyectos',
            'tsysVarHandler' => 'pyeliminar',
        ],[
        	'tsysModulo' => 'presupuesto',
    		'tsysFunction' => 'Ver',
    		'tsysDescF' => 'Observar los presupuestos de los proyectos',
            'tsysVarHandler' => 'ptover',
        ],[
        	'tsysModulo' => 'presupuesto',
    		'tsysFunction' => 'Registrar',
    		'tsysDescF' => 'Registrar el presupuesto de los proyectos',
            'tsysVarHandler' => 'ptoregistrar',
        ],[
        	'tsysModulo' => 'presupuesto',
    		'tsysFunction' => 'Editar',
    		'tsysDescF' => 'Editar el presupuesto de los proyectos',
            'tsysVarHandler' => 'ptoeditar',
        ],[
        	'tsysModulo' => 'presupuesto',
    		'tsysFunction' => 'Eliminar',
    		'tsysDescF' => 'Eliminar el presupuesto de los proyectos',
            'tsysVarHandler' => 'ptoeliminar',
        ],[
        	'tsysModulo' => 'cronograma',
    		'tsysFunction' => 'Ver',
    		'tsysDescF' => 'Ver el cronograma de ejecución del presupuesto',
            'tsysVarHandler' => 'crnver',
        ],[
        	'tsysModulo' => 'cronograma',
    		'tsysFunction' => 'Registrar',
    		'tsysDescF' => 'Registrar el cronograma de ejecución del presupuesto',
            'tsysVarHandler' => 'crnregistrar',
        ],[
        	'tsysModulo' => 'cronograma',
    		'tsysFunction' => 'Editar',
    		'tsysDescF' => 'Editar el cronograma de ejecución del presupuesto',
            'tsysVarHandler' => 'crneditar',
        ],[
        	'tsysModulo' => 'cronograma',
    		'tsysFunction' => 'Eliminar',
    		'tsysDescF' => 'Eliminar el cronograma de ejecución del presupuesto',
            'tsysVarHandler' => 'crneliminar',
        ],[
        	'tsysModulo' => 'avance',
    		'tsysFunction' => 'Ver',
    		'tsysDescF' => 'Ver el avance de metrados del presupuesto',
            'tsysVarHandler' => 'avcver',
        ],[
        	'tsysModulo' => 'avance',
    		'tsysFunction' => 'Registrar',
    		'tsysDescF' => 'Registrar el avance de metrados del presupuesto',
            'tsysVarHandler' => 'avcregistrar',
        ],[
        	'tsysModulo' => 'avance',
    		'tsysFunction' => 'Editar',
    		'tsysDescF' => 'Editar el avance de ejecución del presupuesto',
            'tsysVarHandler' => 'avceditar',
        ],[
        	'tsysModulo' => 'avance',
    		'tsysFunction' => 'Eliminar',
    		'tsysDescF' => 'Eliminar el avance de ejecución del presupuesto',
            'tsysVarHandler' => 'avceliminar',
        ],[
            'tsysModulo' => 'curva',
            'tsysFunction' => 'Ver',
            'tsysDescF' => 'Mostrar las curva S de ejecución de obra',
            'tsysVarHandler' => 'crvver',
        ],[
            'tsysModulo' => 'configuracion',
            'tsysFunction' => 'Ver',
            'tsysDescF' => 'Mostrar las opciones de configuración del sistema',
            'tsysVarHandler' => 'cnfver',
        ]]);
    }
}
