<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Exception;
use PDO;
use PDOException;

class CajaModel 
{
    private $citaModel;
    private $ingresarModel;
    private $areasQueVanAEnfermeria=[
        'Medicina',
        'Pediatria',
        'Ginecologia',
        'Reumatologia',
        'Dermatologia',
        'Terapia Energetica',
        'Terapia Fisica',
        'Terapia Respiratoria',
        'Cardiologia',
        'Alergologia',
        'Odontologia',
        'Psicologia',
        'Inyeccion',
        'Curacion',
        'Presion Arterial',
        'Ecografia'
    ];

    public function __construct()
    {
        $this->citaModel = new CitaModel();
        $this->ingresarModel = new IngresarModel();
    }
    
    public function save()
    {

        try {
            DB::beginTransaction(); //comenzamos una transaccion
            
            //Consultar si el paciente existe en la BD
            $numDB = $this->ingresarModel->exits();
            //Si no existe se crea el paciente y se crea la cita
            if ($numDB<=0) {
                
                //Agregamos al paciente a la tabla ingresar
                $num = $this->ingresarModel->save();
                //Agregamos la cita a la tabla citas
                $this->citaModel->num=$num; //asignamos el id del paciente agregado
                $idCita=$this->citaModel->save();
                if(in_array($this->citaModel->areaaCita,$this->areasQueVanAEnfermeria)){
                    //Agregamos la cita a enfermeria
                    DB::insert('insert into enfermeria (id) values (?)', [$idCita]);
                }
            } else { //solo creamos la cita
                //$this->citaModel->num=$numDB;
                $idCita=$this->citaModel->save();
                if(in_array($this->citaModel->areaaCita,$this->areasQueVanAEnfermeria)){
                    //Agregamos la cita a enfermeria
                    DB::insert('insert into enfermeria (id) values (?)', [$idCita]);
                }
            }
            DB::commit();
            return true;
        } catch (Exception $ex) {
            error_log("ERROR CAJAMODEL: ".$ex);
            try {
                DB::rollBack();
                return false;
            } catch (Exception $e) {
                error_log("ERROR ROLLBACK: ".$e->getMessage());
                return false;
            }
            return false;
        }
    }
    //Obtiene todos los pacientes
    public function getAll()
    {
        try {
            return DB::select("SELECT B.id, CONCAT(A.apellidos,' ',A.nombres) as apenom, A.nacimiento, A.sexo,
            B.areaaCita
            from  ingresar A inner join citas B on A.num=B.num
            where  B.estadisticas != 'o';");
            
        } catch (PDOException $e) {
            return false;
        }
    }
    public function get($id)
    {
    }
    public function delete($id)
    {
    }
    public function update()
    {
    }
    /**
     * @array parametro es un  arreglo con los datos necesarios
     */
    public function from($array)
    {
        //ingresar model
        $this->ingresarModel->from($array);
        //cita model
        $this->citaModel->from($array);
    }

    /**
     * Get the value of citaModel
     */
    public function getCitaModel()
    {
        return $this->citaModel;
    }

    /**
     * Set the value of citaModel
     *
     * @return  self
     */
    public function setCitaModel($citaModel)
    {
        $this->citaModel = $citaModel;

        return $this;
    }

    /**
     * Get the value of ingresarModel
     */
    public function getIngresarModel()
    {
        return $this->ingresarModel;
    }

    /**
     * Set the value of ingresarModel
     *
     * @return  self
     */
    public function setIngresarModel($ingresarModel)
    {
        $this->ingresarModel = $ingresarModel;

        return $this;
    }
}
