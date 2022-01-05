<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;

class IngresarModel
{
    public $num;
    public $fecha;
    public $cedula;
    public $apellidos;
    public $nombres;
    public $nacimiento;
    public $sexo;
    public $telefono;
    public $domicilio; 
    public $provincias;
    public $ciudad;
    public $historial;
    public $fecha_historial;
    public $estadisticas;



    public function save()
    {
        return DB::table('ingresar')->insertGetId(
            ['fecha'=>$this->fecha,
            'cedula'=>$this->cedula,
            'apellidos'=>$this->apellidos,
            'nombres'=>$this->nombres,
            'nacimiento'=>$this->nacimiento,
            'sexo'=>$this->sexo,
            'telefono'=>$this->telefono,
            'domicilio'=>$this->domicilio,
            'provincias'=>$this->provincias,
            'ciudad'=>$this->ciudad
            ]
        );
    }
    //método para validar si existe un paciente o no, por cedula
    public function exits()
    {
        $object=DB::table('ingresar')->where('cedula','=',$this->cedula)->first(['num']);
        /*$paciente=DB::select('SELECT num, cedula, apellidos, nombres, nacimiento, sexo, telefono, domicilio, 
        provincias, ciudad from ingresar where cedula=?',[
            $this->cedula
        ]);*/
        
        if(is_null($object)){
            return -1;
        }
        return $object->num;
    }
    public function from($array)
    {
        $this->fecha = $array['fecha'];
        $this->cedula = $array['cedula'];
        $this->apellidos = $array['apellidos'];
        $this->nombres = $array['nombres'];
        $this->nacimiento = $array['nacimiento'];
        $this->sexo = $array['sexo'];
        $this->telefono = $array['telefono'];
        $this->domicilio = $array['domicilio'];
        $this->provincias = $array['provincia'];
        $this->ciudad = $array['ciudad'];
    }
    public function buscar($cedula)
    {
        return DB::table('ingresar')->where('cedula',$cedula)->first(['num', 'cedula', 'apellidos', 'nombres', 
        'nacimiento', 'sexo', 'telefono', 'domicilio', 
        'provincias', 'ciudad']);
        
    }
    public function buscarPorCedulaOApellido($opcion)
    {
        return DB::table('ingresar')
        ->where('cedula','=',$opcion)
        ->orWhere('apellidos', 'LIKE', '%' . $opcion . '%')
        ->get();
    }
    /*public function saveWithTransaction($pdo)
    {
        $stmt = $pdo->prepare('insert into ingresar (fecha, cedula, apellidos, nombres, nacimiento, 
            sexo, telefono, domicilio, provincias, ciudad) 
            values (?,?,?,?,?,?,?,?,?,?)');
        $stmt->bindParam(1, $this->fecha);
        $stmt->bindParam(2, $this->cedula);
        $stmt->bindParam(3, $this->apellidos);
        $stmt->bindParam(4, $this->nombres);
        $stmt->bindParam(5, $this->nacimiento);
        $stmt->bindParam(6, $this->sexo);
        $stmt->bindParam(7, $this->telefono);
        $stmt->bindParam(8, $this->domicilio);
        $stmt->bindParam(9, $this->provincias);
        $stmt->bindParam(10, $this->ciudad);
        $stmt->execute();
        return $pdo->lastInsertId();
    }
    public function getAll()
    {
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
    public function buscar($cedula)
    {
        $this->connect();
        $stmt=$this->prepare('SELECT num, cedula, apellidos, nombres, nacimiento, sexo, telefono, domicilio, 
        provincias, ciudad from ingresar where cedula=?');
        $stmt->bindParam(1,$cedula);
        $stmt->execute();
        $paciente=$stmt->fetch(PDO::FETCH_ASSOC);
        $this->close();
        return $paciente;
    }
    public function buscarPorCedulaOApellido($opcion)
    {
        
        $this->connect();
        $stmt=$this->prepare("SELECT num, cedula, apellidos, nombres, nacimiento, sexo, telefono, domicilio, 
        provincias, ciudad from ingresar where cedula=? or apellidos like CONCAT('%',?,'%')");
        $stmt->bindParam(1,$opcion);
        $stmt->bindParam(2,$opcion);
        $stmt->execute();
        $pacientes=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->close();
        return $pacientes;
    }
    public function exits()
    {
        $this->connect();
        $stmt=$this->prepare('SELECT num, cedula, apellidos, nombres, nacimiento, sexo, telefono, domicilio, 
        provincias, ciudad from ingresar where cedula=?');
        $stmt->bindParam(1,$this->cedula);
        $stmt->execute();
        $paciente=$stmt->fetch(PDO::FETCH_ASSOC);
        $existe=empty($paciente)? false:true;
        $this->close();
        return $existe;
    }
    
*/





    /**
     * Get the value of id
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get the value of fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of cedula
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * Set the value of cedula
     *
     * @return  self
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;

        return $this;
    }

    /**
     * Get the value of apellidos
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of nombres
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set the value of nombres
     *
     * @return  self
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get the value of nacimiento
     */
    public function getNacimiento()
    {
        return $this->nacimiento;
    }

    /**
     * Set the value of nacimiento
     *
     * @return  self
     */
    public function setNacimiento($nacimiento)
    {
        $this->nacimiento = $nacimiento;

        return $this;
    }

    /**
     * Get the value of sexo
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set the value of sexo
     *
     * @return  self
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get the value of telefono
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     *
     * @return  self
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of domicilio
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set the value of domicilio
     *
     * @return  self
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get the value of provincias
     */
    public function getProvincias()
    {
        return $this->provincias;
    }

    /**
     * Set the value of provincias
     *
     * @return  self
     */
    public function setProvincias($provincias)
    {
        $this->provincias = $provincias;

        return $this;
    }

    /**
     * Get the value of ciudad
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set the value of ciudad
     *
     * @return  self
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get the value of historial
     */
    public function getHistorial()
    {
        return $this->historial;
    }

    /**
     * Set the value of historial
     *
     * @return  self
     */
    public function setHistorial($historial)
    {
        $this->historial = $historial;

        return $this;
    }

    /**
     * Get the value of fecha_historial
     */
    public function getFecha_historial()
    {
        return $this->fecha_historial;
    }

    /**
     * Set the value of fecha_historial
     *
     * @return  self
     */
    public function setFecha_historial($fecha_historial)
    {
        $this->fecha_historial = $fecha_historial;

        return $this;
    }

    /**
     * Get the value of estadisticas
     */
    public function getEstadisticas()
    {
        return $this->estadisticas;
    }

    /**
     * Set the value of estadisticas
     *
     * @return  self
     */
    public function setEstadisticas($estadisticas)
    {
        $this->estadisticas = $estadisticas;

        return $this;
    }
}
