<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class AntecedenteModel
{

    private $id;
    private $idOdo;
    private $descripcion;
    private $detalles; //Array que contiene los ids de los antecedentes_opciones

    public function __construct()
    {
    }

    public function saveWithTransaction()
    {
        $id = DB::table('antecedente')->insertGetId([
            'id_odo' => $this->idOdo,
            'descripcion'=>$this->descripcion
        ]);

        foreach ($this->detalles as $value) {
            DB::insert('Insert into antecedentes_detalles(id_ant,id_ant_op) 
                values(?,?)', [
                $id,
                $value['id']
            ]);
        }
    }
    
    public function getAntecedentes($idOdo)
    {
        $result=DB::selectOne('select * from antecedente where id_odo=?', [$idOdo]);
        $idAnt=$result->id;
        $detalles=$this->getAntecedenteDetalles($idAnt);
        return ['general'=>$result,'detalles'=>$detalles];
    }

    private function getAntecedenteDetalles($idAnt)
    {
        return DB::select('select ao.nombre
        from antecedentes_detalles ad inner join antecedentes_opciones ao
        on ao.id=ad.id_ant_op 
        where ad.id_ant=?', 
        [
            $idAnt
        ]);
    }

    public function setData($data)
    {
        $this->descripcion=$data['descripcion'];
        $this->detalles=$data['detalles'];
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
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of detalles
     */ 
    public function getDetalles()
    {
        return $this->detalles;
    }

    /**
     * Set the value of detalles
     *
     * @return  self
     */ 
    public function setDetalles($detalles)
    {
        $this->detalles = $detalles;

        return $this;
    }
}
