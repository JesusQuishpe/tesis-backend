<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PDOException;

class EnfermeriaModel
{
    private $ide;
    private $id;
    private $peso;
    private $estatura;
    private $temperatura;
    private $presion;
    private $enfermeria;
    private $medico;
    private $terapia;
    private $discapacidad;
    private $inyeccion;
    private $curacion;
    private $embarazo;
    private $enfermera;
    private $cardiopatia;
    private $diabetes;
    private $hipertension;
    private $cirugias;
    private $alergias_medicina;
    private $alergias_comida;
    private $atendido;


    public function save()
    {
        try {
            DB::beginTransaction();
            DB::insert("INSERT INTO enfermeria (id,peso,estatura,temperatura,presion,medico,discapacidad,embarazo,enfermera,inyeccion,curacion,atendido) values
            (?,?,?,?,?,?,?,?,?,?,?,?)", [
                $this->id,
                $this->peso,
                $this->estatura,
                $this->temperatura,
                $this->presion,
                $this->medico,
                $this->discapacidad,
                $this->embarazo,
                $this->enfermera,
                $this->inyeccion,
                $this->curacion,
                $this->atendido
            ]);
            //Actualizamos el campo atendidoEnfermeria que indica que ese paciente ha sido atendido en enfermeria
            DB::update("UPDATE citas set atendidoEnfermeria=1 where id=?", [$this->id]);
            DB::commit();
            return true;
        } catch (PDOException $e) {
            try {
                DB::rollback();
            } catch (PDOException $er) {
                return false;
            }
            return false;
        }
    }

    public function terminarAtencion()
    {
        DB::update('update enfermeria set peso = ?,
        estatura=?,
        temperatura=?,
        presion=?,
        medico=?,
        discapacidad=?,
        embarazo=?,
        enfermera=?,
        inyeccion=?,
        curacion=?,
        atendido=?
        where ide = ?', [
            $this->peso,
            $this->estatura,
            $this->temperatura,
            $this->presion,
            $this->medico,
            $this->discapacidad,
            $this->embarazo,
            $this->enfermera,
            $this->inyeccion,
            $this->curacion,
            $this->atendido,
            $this->ide
        ]);
    }


    //Obtener todos los pacientes que agendaron una cita.
    public function getAll()
    {
        try {
            return DB::select("SELECT B.id, CONCAT(A.apellidos,' ',A.nombres) as apenom, A.nacimiento, A.sexo,
            B.areaaCita
            from  ingresar A inner join citas B on A.num=B.num
            where B.areaaCita!='Laboratorio' and B.estadisticas!='o' and B.atendidoEnfermeria=0");
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getPacientesEnEspera()
    {
        return DB::select("SELECT e.ide,c.id, CONCAT(i.apellidos,' ',i.nombres) as apenom, i.nacimiento, i.sexo,
            c.areaaCita
            from enfermeria e inner join citas c on e.id=c.id
            inner join ingresar i on i.num=c.num
            where e.atendido=0");
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

    public function from($array)
    {
        $this->ide=$array['ide'];
        //$this->id = $array['id'];
        $this->peso = $array['peso'];
        $this->estatura = $array['estatura'];
        $this->temperatura = $array['temperatura'];
        $this->presion = $array['presion'];
        $this->discapacidad = $array['discapacidad'];
        $this->embarazo = $array['embarazo'];
        $this->inyeccion = $array['inyeccion'];
        $this->curacion = $array['curacion'];
        $this->medico = $array['medico'];
        $this->enfermera = $array['enfermera'];
        $this->atendido = $array['atendido'];
    }



    public function getPeso()
    {
        return $this->peso;
    }

    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }


    public function getEstatura()
    {
        return $this->estatura;
    }

    public function setEstatura($estatura)
    {
        $this->estatura = $estatura;

        return $this;
    }


    public function getTemperatura()
    {
        return $this->temperatura;
    }

    public function setTemperatura($temperatura)
    {
        $this->temperatura = $temperatura;

        return $this;
    }


    public function getPresion()
    {
        return $this->presion;
    }

    public function setPresion($presion)
    {
        $this->presion = $presion;

        return $this;
    }


    public function getEnfermeria()
    {
        return $this->enfermeria;
    }

    public function setEnfermeria($enfermeria)
    {
        $this->enfermeria = $enfermeria;

        return $this;
    }


    public function getMedico()
    {
        return $this->medico;
    }

    public function setMedico($medico)
    {
        $this->medico = $medico;

        return $this;
    }


    public function getTerapia()
    {
        return $this->terapia;
    }

    public function setTerapia($terapia)
    {
        $this->terapia = $terapia;

        return $this;
    }


    public function getDiscapacidad()
    {
        return $this->discapacidad;
    }

    public function setDiscapacidad($discapacidad)
    {
        $this->discapacidad = $discapacidad;

        return $this;
    }


    public function getInyeccion()
    {
        return $this->inyeccion;
    }

    public function setInyeccion($inyeccion)
    {
        $this->inyeccion = $inyeccion;

        return $this;
    }


    public function getCuracion()
    {
        return $this->curacion;
    }

    public function setCuracion($curacion)
    {
        $this->curacion = $curacion;

        return $this;
    }


    public function getEmbarazo()
    {
        return $this->embarazo;
    }

    public function setEmbarazo($embarazo)
    {
        $this->embarazo = $embarazo;

        return $this;
    }


    public function getEnfermera()
    {
        return $this->enfermera;
    }

    public function setEnfermera($enfermera)
    {
        $this->enfermera = $enfermera;

        return $this;
    }


    public function getCardiopatia()
    {
        return $this->cardiopatia;
    }

    public function setCardiopatia($cardiopatia)
    {
        $this->cardiopatia = $cardiopatia;

        return $this;
    }


    public function getDiabetes()
    {
        return $this->diabetes;
    }

    public function setDiabetes($diabetes)
    {
        $this->diabetes = $diabetes;

        return $this;
    }


    public function getHipertension()
    {
        return $this->hipertension;
    }

    public function setHipertension($hipertension)
    {
        $this->hipertension = $hipertension;

        return $this;
    }


    public function getCirugias()
    {
        return $this->cirugias;
    }

    public function setCirugias($cirugias)
    {
        $this->cirugias = $cirugias;

        return $this;
    }


    public function getAlergias_medicina()
    {
        return $this->alergias_medicina;
    }

    public function setAlergias_medicina($alergias_medicina)
    {
        $this->alergias_medicina = $alergias_medicina;

        return $this;
    }


    public function getAlergias_comida()
    {
        return $this->alergias_comida;
    }

    public function setAlergias_comida($alergias_comida)
    {
        $this->alergias_comida = $alergias_comida;

        return $this;
    }


    public function getId_enf()
    {
        return $this->id_enf;
    }

    public function setId_enf($id_enf)
    {
        $this->id_enf = $id_enf;

        return $this;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
