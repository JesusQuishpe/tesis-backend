<?php
namespace App\Models;
use PDOException;
use Illuminate\Support\Facades\DB;

class CitaModel
{
    public $id;
    public $fechaCita;
    public $horaCita;
    public $cedulaCita;
    public $areaaCita;
    public $valorCita;
    public $facturaCita;
    public $estadoCita;
    public $num; //Este es el  id del paciente
    public $estadisticas;
    
    
    public function save()
    {
        return DB::table('citas')->insertGetId([
            'fechaCita'=>$this->fechaCita,
            'horaCita'=>$this->horaCita,
            'cedulaCita'=>$this->cedulaCita,
            'areaaCita'=>$this->areaaCita,
            'valorCita'=>$this->valorCita,
            'num'=>$this->num,
        ]);
        
    }
    public function from($array)
    {
        $this->cedulaCita = $array['cedula'];
        $this->fechaCita=$array['fecha'];
        $this->horaCita=$array['hora'];
        $this->areaaCita=$array['area'];
        $this->valorCita=$array['valor'];
        $this->num=$array['num'];
    }
    
    //Get all patients
    /*public function getAll()
    {
        try {
            $stmt = $this->query("SELECT B.id, CONCAT(A.apellidos,' ',A.nombres) as apenom, A.nacimiento, A.sexo,
            B.areaa_cita
            from  ingresar A inner join citas B on A.num=B.num
            where  B.estadisticas != 'o';");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    
    //Getters and Setters
    public function setId($value)
    {
        $this->id = $value;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setFechaCita($value)
    {
        $this->fechaCita = $value;
    }
    public function getFechaCita()
    {
        return $this->fechaCita;
    }
    public function setHoraCita($value)
    {
        $this->horaCita = $value;
    }
    public function getHoraCita()
    {
        return $this->horaCita;
    }
    public function setCedulaCita($value)
    {
        $this->cedulaCita = $value;
    }
    public function getCedulaCita()
    {
        return $this->cedulaCita;
    }
    public function setAreaaCita($value)
    {
        $this->areaaCita = $value;
    }
    public function getAreaaCita()
    {
        return $this->areaaCita;
    }
    public function setValorCita($value)
    {
        $this->valorCita = $value;
    }
    public function getValorCita()
    {
        return $this->valorCita;
    }
    public function setFacturaCita($value)
    {
        $this->facturaCita = $value;
    }
    public function getFacturaCita()
    {
        return $this->facturaCita;
    }
    public function setEstadoCita($value)
    {
        $this->estadoCita = $value;
    }
    public function getEstadoCita()
    {
        return $this->estadoCita;
    }
    public function setNum($value)
    {
        $this->num = $value;
    }
    public function getNum()
    {
        return $this->num;
    }
    public function setEstadisticas($value)
    {
        $this->estadisticas = $value;
    }
    public function getEstadisticas()
    {
        return $this->estadisticas;
    }*/
}
