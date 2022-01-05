<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class PlanDiagnosticoModel
{
    private $idOdo;
    private $idPlanOp;
    private $descripcion;

    public function __construct() {
       $this->descripcion="";
    }

    public function saveWithTransaction()
    {
        DB::insert('Insert into plan_diagnostico(id_odo,id_plan_op,descripcion)
        values (?,?,?)',[
        $this->idOdo,
        $this->idPlanOp,
        $this->descripcion
        ]);
    }
    
    public function setData($data)
    {
        $this->idPlanOp=$data['idPlanOp'];
        $this->descripcion=$data['descripcion'];
    }
    
    public function getPlan($idOdo)
    {
        return DB::selectOne('select po.nombre,p.descripcion from plan_diagnostico p 
        inner join plan_opciones po on po.id=p.id_plan_op
        where p.id_odo=?
        ',[$idOdo]);
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
     * Get the value of idPlanOp
     */ 
    public function getIdPlanOp()
    {
        return $this->idPlanOp;
    }

    /**
     * Set the value of idPlanOp
     *
     * @return  self
     */ 
    public function setIdPlanOp($idPlanOp)
    {
        $this->idPlanOp = $idPlanOp;

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
}