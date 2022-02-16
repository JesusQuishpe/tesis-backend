<?php

namespace Database\Seeders;

use App\Models\Modulo;
use Illuminate\Database\Seeder;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modulo=new Modulo();
        $modulo->nombre='Caja';
        $modulo->id_parent=null;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path="/caja";
        $modulo->save();

        $modulo=new Modulo();
        $modulo->nombre='Enfermeria';
        $modulo->id_parent=null;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path="/enfermeria";
        $modulo->save();

        $modulo=new Modulo();
        $modulo->nombre='Medicina';
        $modulo->id_parent=null;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path="/medicina";
        $modulo->save();

        $modulo=new Modulo();
        $modulo->nombre='Odontologia';
        $modulo->id_parent=null;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path="/odontologia";
        $modulo->save();

        $modulo=new Modulo();
        $modulo->nombre='Laboratorio';
        $modulo->id_parent=null;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path="/laboratorio";
        $modulo->save();

        $modulo=new Modulo();
        $modulo->nombre='Mantenimiento';
        $modulo->id_parent=null;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path="/mantenimiento";
        $modulo->save();

        //Submodulos de caja
        /*$modulo=new Modulo();
        $modulo->nombre='Nueva cita';
        $modulo->id_parent=1;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/caja/nuevo';
        $modulo->save();

        $modulo=new Modulo();
        $modulo->nombre='Cambios';
        $modulo->id_parent=1;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/caja/cambios';
        $modulo->save();



        Submodulos de medicina
        $modulo=new Modulo();
        $modulo->nombre='En espera';
        $modulo->id_parent=3;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/medicina/pacientes';
        $modulo->save();

        $modulo=new Modulo();
        $modulo->nombre='Historial';
        $modulo->id_parent=3;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/medicina/historial';
        $modulo->save();

        Submodulos odontologia
        $modulo=new Modulo();
        $modulo->nombre='En espera';
        $modulo->id_parent=4;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/odontologia/pacientes';
        $modulo->save();

        $modulo=new Modulo();
        $modulo->nombre='Todos';
        $modulo->id_parent=4;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/odontologia/todos';
        $modulo->save();
        */
        //Submodulos de laboratorio
        $modulo=new Modulo();
        $modulo->nombre='Unidades de medida';
        $modulo->id_parent=5;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/unidades';
        $modulo->save();

        $modulo=new Modulo();
        $modulo->nombre='Titulos';
        $modulo->id_parent=5;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/titulos';
        $modulo->save();


        $modulo=new Modulo();
        $modulo->nombre='Examenes';
        $modulo->id_parent=5;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/examenes';
        $modulo->save();

        $modulo=new Modulo();
        $modulo->nombre='Estudios';
        $modulo->id_parent=5;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/estudios';
        $modulo->save();
        
        $modulo=new Modulo();
        $modulo->nombre='Asignar estudios a examen';
        $modulo->id_parent=5;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/asignacion';
        $modulo->save();
        
        //Submodulos mantenimiento
        $modulo=new Modulo();
        $modulo->nombre='Roles';
        $modulo->id_parent=6;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/roles';
        $modulo->save();

        $modulo=new Modulo();
        $modulo->nombre='Roles y permisos';
        $modulo->id_parent=6;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/permisos';
        $modulo->save();

        $modulo=new Modulo();
        $modulo->nombre='Usuarios';
        $modulo->id_parent=6;
        $modulo->enable=true;
        $modulo->canDelete=false;
        $modulo->path='/usuarios';
        $modulo->save();
    }
}