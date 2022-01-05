<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use JsonSerializable;

class OdontologiaModel implements JsonSerializable
{
    private $idOdo;
    private $idEnf;
    private $cedula;
    private $nombres;
    private $apellidos;
    private $fechaConsultaClie;
    private $seleccionEdad;
    private $motivoConsulta;
    private $enfermedadProblema;
    private $atendido;
    private $actaPath;
    private $fechaConsultaServ;

    public function saveWithTransaction()
    {
        return  DB::table('odontologia')->insertGetId([
            'id_enf' => $this->idEnf,
            'cedula'=>$this->cedula,
            'nombres'=>$this->nombres,
            'apellidos'=>$this->apellidos,
            'fecha_consulta_clie' => $this->fechaConsultaClie,
            'seleccion_edad' => $this->seleccionEdad,
            'motivo_consulta' => $this->motivoConsulta,
            'enfermedad_problema' => $this->enfermedadProblema,
            'atendido'=>$this->atendido,
            'acta_path'=>$this->actaPath,
            'fecha_consulta_serv'=>$this->fechaConsultaServ
        ]);
    }

    public function terminarAtencion()
    {
        DB::update('update odontologia set 
        cedula = ?, 
        nombres = ?,
        apellidos = ?,
        fecha_consulta_clie = ?,
        seleccion_edad = ?,
        motivo_consulta = ?,
        enfermedad_problema = ?,
        atendido = ?,
        acta_path = ?,
        fecha_consulta_serv = ?
        where id_odo = ?', [
            $this->cedula,
            $this->nombres,
            $this->apellidos,
            $this->fechaConsultaClie,
            $this->seleccionEdad,
            $this->motivoConsulta,
            $this->enfermedadProblema,
            $this->atendido,
            $this->actaPath,
            $this->fechaConsultaServ,
            $this->idOdo
        ]);
        return $this->idOdo;
    }
    public function save()
    {
    }
    public function getAll()
    {
        return DB::select('select id_odo,id_enf,cedula,nombres,apellidos,date_format(fecha_consulta_clie, "%d/%m/%Y") as fecha_consulta_clie
         from odontologia where atendido=1 order by UNIX_TIMESTAMP(fecha_consulta_clie) desc', []);
    }
    public function getPorCedulaOApellidos($opcion)
    {
        $opcion='%'.$opcion.'%';
        return DB::select('select * from odontologia where cedula like ? or apellidos like ? and atendido=1', [
            $opcion,
            $opcion
        ]);
    }
    public function getPacientePorCedula($cedula,$idEnf)
    {
        return DB::selectOne('select id_odo as idOdo,id_enf as idEnf,
        cedula,nombres,apellidos,fecha_consulta as fechaConsultaClie,
        seleccion_edad as seleccionEdad,motivo_consulta as motivoConsulta,
        enfermedad_problema as enfermedadProblema,atendido,acta_path as actaPath
        from odontologia where cedula=? and atendido=1 and id_enf=?', [
            $cedula,
            $idEnf
        ]);
        
    }

    public function getUltimoOdontogramaDelPaciente($idOdo)
    {
        
    }

    public function getPorIdOdo($idOdo)
    {
        return DB::selectOne('select o.id_odo as idOdo,o.id_enf as idEnf,
        i.cedula,i.nombres,i.apellidos,i.sexo,i.telefono,i.provincias,i.ciudad,date_format(i.nacimiento,"%d/%m/%Y") as nacimiento,
        date_format(o.fecha_consulta_clie, "%d/%m/%Y") as fechaConsultaClie,
        o.seleccion_edad as seleccionEdad,o.motivo_consulta as motivoConsulta,
        o.enfermedad_problema as enfermedadProblema,o.atendido,o.acta_path as actaPath,
        e.peso,e.estatura,e.temperatura,e.presion
        from odontologia o inner join enfermeria e on e.ide=o.id_enf inner join 
        citas c on c.id=e.id inner join ingresar i on i.num=c.num
        where o.id_odo=?', [
            $idOdo
        ]);
    }


    public function delete($idOdo)
    {
        return DB::delete('delete from odontologia where id_odo = ?', [$idOdo]);
    }
    public function update()
    {
    }
    
    public function from($array)
    {
        $this->idOdo = $array['idOdo'];
        //$this->idEnf = $array['idEnf'];
        $this->cedula = $array['cedula'];
        $this->nombres = $array['nombres'];
        $this->apellidos = $array['apellidos'];
        $date=date_create($array['fechaConsultaClie']);
        $this->fechaConsultaClie = $date;
        $this->seleccionEdad = $array['seleccionEdad'];
        $this->motivoConsulta = $array['motivoConsulta'];
        $this->enfermedadProblema = $array['enfermedadProblema'];
        $this->atendido = true;
        $this->actaPath=$array['acta_path'];
        $this->fechaConsultaServ=date_create();
    }
    public function getPacientesEnEspera()
    {
        return DB::select('SELECT o.id_odo as idOdo,e.ide,i.num,i.cedula,i.nombres,i.apellidos,i.sexo 
        from odontologia o 
        inner join enfermeria e on e.ide=o.id_enf 
        inner join citas c on c.id=e.id
        inner join ingresar i on i.num=c.num 
        where o.atendido=0 and c.estadisticas!=?', ['Odontologia','o']); //Modificar la consulta para que sea con la fecha actual
    }

    public function jsonSerialize()
    {
        return [
            'idOdo'=>$this->idOdo,
            'idEnf'=>$this->idEnf,
            'fechaConsultaClie'=>$this->fechaConsultaClie,
            'seleccionEdad'=>$this->seleccionEdad
        ];
    }

    /**
     * Get the value of idOdo
     */
    public function getIdOdo()
    {
        return $this->idOdo;
    }

    /**
     * Set the value of idOdo
     *
     * @return  self
     */
    public function setIdOdo($idOdo)
    {
        $this->idOdo = $idOdo;

        return $this;
    }

    /**
     * Get the value of idEnf
     */
    public function getIdEnf()
    {
        return $this->idEnf;
    }

    /**
     * Set the value of idEnf
     *
     * @return  self
     */
    public function setIdEnf($idEnf)
    {
        $this->idEnf = $idEnf;

        return $this;
    }

    /**
     * Get the value of fechaConsultaClie
     */
    public function getFechaConsulta()
    {
        return $this->fechaConsultaClie;
    }

    /**
     * Set the value of fechaConsultaClie
     *
     * @return  self
     */
    public function setFechaConsulta($fechaConsultaClie)
    {
        $this->fechaConsultaClie = $fechaConsultaClie;

        return $this;
    }

    /**
     * Get the value of seleccionEdad
     */
    public function getSeleccionEdad()
    {
        return $this->seleccionEdad;
    }

    /**
     * Set the value of seleccionEdad
     *
     * @return  self
     */
    public function setSeleccionEdad($seleccionEdad)
    {
        $this->seleccionEdad = $seleccionEdad;

        return $this;
    }

    /**
     * Get the value of motivoConsulta
     */
    public function getMotivoConsulta()
    {
        return $this->motivoConsulta;
    }

    /**
     * Set the value of motivoConsulta
     *
     * @return  self
     */
    public function setMotivoConsulta($motivoConsulta)
    {
        $this->motivoConsulta = $motivoConsulta;

        return $this;
    }

    /**
     * Get the value of enfermedadProblema
     */
    public function getEnfermedadProblema()
    {
        return $this->enfermedadProblema;
    }

    /**
     * Set the value of enfermedadProblema
     *
     * @return  self
     */
    public function setEnfermedadProblema($enfermedadProblema)
    {
        $this->enfermedadProblema = $enfermedadProblema;

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
}
