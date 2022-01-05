<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class TratamientosModel 
{
    private $idOdo;
    private $sesion;
    private $diagComplica;
    private $procedimientos;
    private $prescripciones;
    public function __construct() {
        
    }
    public function saveWithTransaction()
    {
        DB::insert('Insert into tratamientos(id_odo,sesion,diag_complica,procedimientos,prescripciones) 
        values(?,?,?,?,?)',[
        $this->idOdo,
        $this->sesion,
        $this->diagComplica,
        $this->procedimientos,
        $this->prescripciones
        ]);
    }
    public function saveTrasactionFromArray($pdo,$tratamientos,$idOdo)
    {
        foreach ($tratamientos as $trat) {
            $this->from($trat);
            $this->idOdo=$idOdo;
            $this->tratamientosModel->saveWithTransaction($pdo);
        }
    }
    public function save(){

    }
    public function getAll(){

    }
    public function getPorIdOdo($idOdo){
        return DB::select('select t.id_odo as idOdo,
        t.sesion,
        t.diag_complica as diagComplica,
        t.procedimientos,
        t.prescripciones
        from tratamientos t 
        where t.id_odo = ?', [$idOdo]);
    }
    public function delete($id){
        
    }
    public function update(){

    }
    public function from($array){
        //$this->idOdo=$array['idOdo'];
        $this->sesion=$array['sesion'];
        $this->diagComplica=$array['diagComplica'];
        $this->procedimientos=$array['procedimientos'];
        $this->prescripciones=$array['prescripciones'];
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
     * Get the value of sesion
     */ 
    public function getSesion()
    {
        return $this->sesion;
    }

    /**
     * Set the value of sesion
     *
     * @return  self
     */ 
    public function setSesion($sesion)
    {
        $this->sesion = $sesion;

        return $this;
    }

    /**
     * Get the value of diagComplica
     */ 
    public function getDiagComplica()
    {
        return $this->diagComplica;
    }

    /**
     * Set the value of diagComplica
     *
     * @return  self
     */ 
    public function setDiagComplica($diagComplica)
    {
        $this->diagComplica = $diagComplica;

        return $this;
    }

    /**
     * Get the value of procedimientos
     */ 
    public function getProcedimientos()
    {
        return $this->procedimientos;
    }

    /**
     * Set the value of procedimientos
     *
     * @return  self
     */ 
    public function setProcedimientos($procedimientos)
    {
        $this->procedimientos = $procedimientos;

        return $this;
    }

    /**
     * Get the value of prescripciones
     */ 
    public function getPrescripciones()
    {
        return $this->prescripciones;
    }

    /**
     * Set the value of prescripciones
     *
     * @return  self
     */ 
    public function setPrescripciones($prescripciones)
    {
        $this->prescripciones = $prescripciones;

        return $this;
    }
}