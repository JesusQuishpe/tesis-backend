<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class IndicesModel 
{
    private $id;
    private $idOdo;
    private $cd;
    private $pd;
    private $od;
    private $ce;
    private $ee;
    private $oe;
    private $totalCpo;
    private $totalCeo;
    
    public function __construct() {
        
    }
    public function saveWithTransaction()
    {
        DB::insert('Insert into indices (id_odo,c_d,p_d,o_d,c_e,e_e,o_e,total_cpo,total_ceo)
        values(?,?,?,?,?,?,?,?,?)',[
        $this->idOdo,
        $this->cd,
        $this->pd,
        $this->od,
        $this->ce,
        $this->ee,
        $this->oe,
        $this->totalCpo,
        $this->totalCeo
        ]);
    }
    public function save(){

    }
    public function getAll(){

    }
    public function getPorCedula($cedula,$idEnf){
        return DB::select('select id_odo as idOdo,c_d as cd,p_d as pd, o_d as od,
        c_e as ce,
        e_e as ee,
        o_e as oe,
        total_cpo as totalCpo,
        total_ceo as totalCeo
        from indices  
        where cedula=? and atendido=1 and id_enf=?', [
            $cedula,
            $idEnf
        ]);
    }
    public function getPorIdOdo($idOdo){
        return DB::selectOne('select id_odo as idOdo,c_d as cd,p_d as pd, o_d as od,
        c_e as ce,
        e_e as ee,
        o_e as oe,
        total_cpo as totalCpo,
        total_ceo as totalCeo
        from indices  
        where id_odo=?', [
            $idOdo
        ]);
    }
    public function delete($id){

    }
    public function update(){

    }
    public function from($indices){
        //$this->id=$indices['id'];
        //$this->idOdo=$indices['idOdo'];
        $this->cd=$indices['cpo_c'];
        $this->pd=$indices['cpo_p'];
        $this->od=$indices['cpo_o'];
        $this->ce=$indices['ceo_c'];
        $this->ee=$indices['ceo_e'];
        $this->oe=$indices['ceo_o'];
        $this->totalCpo=$indices['cpo_total'];
        $this->totalCeo=$indices['ceo_total'];
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
     * Get the value of cd
     */ 
    public function getCd()
    {
        return $this->cd;
    }

    /**
     * Set the value of cd
     *
     * @return  self
     */ 
    public function setCd($cd)
    {
        $this->cd = $cd;

        return $this;
    }

    /**
     * Get the value of pd
     */ 
    public function getPd()
    {
        return $this->pd;
    }

    /**
     * Set the value of pd
     *
     * @return  self
     */ 
    public function setPd($pd)
    {
        $this->pd = $pd;

        return $this;
    }

    /**
     * Get the value of od
     */ 
    public function getOd()
    {
        return $this->od;
    }

    /**
     * Set the value of od
     *
     * @return  self
     */ 
    public function setOd($od)
    {
        $this->od = $od;

        return $this;
    }

    /**
     * Get the value of ce
     */ 
    public function getCe()
    {
        return $this->ce;
    }

    /**
     * Set the value of ce
     *
     * @return  self
     */ 
    public function setCe($ce)
    {
        $this->ce = $ce;

        return $this;
    }

    /**
     * Get the value of ee
     */ 
    public function getEe()
    {
        return $this->ee;
    }

    /**
     * Set the value of ee
     *
     * @return  self
     */ 
    public function setEe($ee)
    {
        $this->ee = $ee;

        return $this;
    }

    /**
     * Get the value of oe
     */ 
    public function getOe()
    {
        return $this->oe;
    }

    /**
     * Set the value of oe
     *
     * @return  self
     */ 
    public function setOe($oe)
    {
        $this->oe = $oe;

        return $this;
    }

    /**
     * Get the value of totalCpo
     */ 
    public function getTotalCpo()
    {
        return $this->totalCpo;
    }

    /**
     * Set the value of totalCpo
     *
     * @return  self
     */ 
    public function setTotalCpo($totalCpo)
    {
        $this->totalCpo = $totalCpo;

        return $this;
    }

    /**
     * Get the value of totalCeo
     */ 
    public function getTotalCeo()
    {
        return $this->totalCeo;
    }

    /**
     * Set the value of totalCeo
     *
     * @return  self
     */ 
    public function setTotalCeo($totalCeo)
    {
        $this->totalCeo = $totalCeo;

        return $this;
    }
}