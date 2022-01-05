<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use JsonSerializable;

class IndicadoresModel implements JsonSerializable
{
    private $idIndsb;
    private $idOdo;
    private $enfPeriod;
    private $malOclu;
    private $fluorosis;
    private $totalPlaca;
    private $totalCalc;
    private $totalGin;
    private $detalles;//array de la clase IndicadoresDetalleModel: contiene los detalles 
    public function __construct() {
        $this->detalles=[];
    }

    public function saveWithTransaction()
    {
        //Agregamos los indicadores: parametros generales
        $id=DB::table('indicadores_sb')->insertGetId(
        [
            'id_odo'=>$this->idOdo,
            'enf_period'=>$this->enfPeriod,
            'mal_oclu'=>$this->malOclu,
            'fluorosis'=>$this->fluorosis,
            'total_placa'=>$this->totalPlaca,
            'total_calc'=>$this->totalCalc,
            'total_gin'=>$this->totalGin
        ]);
        
        //Agregamos los detalles
        foreach ($this->detalles as $ind) {
            $ind->setIdIndsb($id);
            $ind->saveWithTransaction();
        }
    }


    public function getPorCedula($cedula,$idEnf){
        $indicadores=[];
        $indicador=DB::selectOne('select i.id_indsb as idIndsb,
        i.id_odo as idOdo,i.enf_period as enfPeriod,i.mal_oclu as malOclu, i.fluorosis,
        i.total_placa as totalPlaca,i.total_calc as totalCalc, i.total_gin as totalGin
        from indicadores_sb i inner join odontologia o on
        o.id_odo=i.id_odo where o.cedula=? and o.id_enf=?
        ',[
            $cedula,
            $idEnf
        ]);

        $detalles=DB::select('select idet.id_indsb as idIndsb,
        idet.num_pieza1 as numPieza1,
        idet.num_pieza2 as numPieza2,
        idet.num_pieza3 as numPieza3,
        idet.num_placa as numPlaca,
        idet.num_calc as numCalc,
        idet.num_gin as numGin
        from indicadores_detalles idet
        inner join indicadores_sb i on idet.id_indsb=i.id_indsb 
        where idet.id_indsb=?
        ', [
            $indicador['idIndsb']
        ]);
        array_push($indicadores,$indicador,$detalles);
        return $indicadores;
    }

    public function getPorIdOdo($idOdo){
        $indicadores=[];
        $indicador=DB::selectOne('select i.id_indsb as idIndsb,
        i.id_odo as idOdo,i.enf_period as enfPeriod,i.mal_oclu as malOclu, i.fluorosis,
        i.total_placa as totalPlaca,i.total_calc as totalCalc, i.total_gin as totalGin
        from indicadores_sb i where i.id_odo=?
        ',[
            $idOdo
        ]);
        
        $detalles=DB::select('select idet.id_indsb as idIndsb,
        idet.num_pieza1 as numPieza1,
        idet.num_pieza2 as numPieza2,
        idet.num_pieza3 as numPieza3,
        idet.num_placa as numPlaca,
        idet.num_calc as numCalc,
        idet.num_gin as numGin
        from indicadores_detalles idet
        inner join indicadores_sb i on idet.id_indsb=i.id_indsb 
        where idet.id_indsb=?', 
        [
            $indicador->idIndsb
        ]);

        $indicadores['general']=$indicador;
        $indicadores['detalles']=$detalles;

        return $indicadores;
    }

    public function from($indicadores){

        $this->enfPeriod=$indicadores['enfPeriod'];
        $this->malOclu=$indicadores['malOclu'];
        $this->fluorosis=$indicadores['fluorosis'];
        $this->totalPlaca=$indicadores['totalPlaca'];
        $this->totalCalc=$indicadores['totalCalc'];
        $this->totalGin=$indicadores['totalGin'];

        foreach ($indicadores['detalles'] as $value) {
            $detalle=new IndicadorDetalleModel();
            $detalle->from($value);
            array_push($this->detalles,$detalle);
        }
        /*$this->idIndsb=$array['idIndsb'];
        $this->idOdo=$array['idOdo'];
        $this->enfPeriod=$array['enfPeriod'];
        $this->malOclu=$array['malOclu'];
        $this->fluorosis=$array['fluorosis'];
        $this->totalPlaca=$array['totalPlaca'];
        $this->totalCalc=$array['totalCalc'];
        $this->totalGin=$array['totalGin'];
        $this->detalles=$array['detalles'];*/
    }

    public function jsonSerialize()
    {
        return [
            'enfPeriod'=>$this->enfPeriod,
            'malOclu'=>$this->malOclu,
            'fluorosis'=>$this->fluorosis,
            'totalPlaca'=>$this->totalPlaca,
            'totalCalc'=>$this->totalCalc,
            'totalGin'=>$this->enfPeriod,
            'detalles'=>$this->detalles
        ];
    }

    /**
     * Get the value of idIndsb
     */ 
    public function getIdIndsb()
    {
        return $this->idIndsb;
    }

    /**
     * Set the value of idIndsb
     *
     * @return  self
     */ 
    public function setIdIndsb($idIndsb)
    {
        $this->idIndsb = $idIndsb;

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
     * Get the value of enfPeriod
     */ 
    public function getEnfPeriod()
    {
        return $this->enfPeriod;
    }

    /**
     * Set the value of enfPeriod
     *
     * @return  self
     */ 
    public function setEnfPeriod($enfPeriod)
    {
        $this->enfPeriod = $enfPeriod;

        return $this;
    }

    /**
     * Get the value of malOclu
     */ 
    public function getMalOclu()
    {
        return $this->malOclu;
    }

    /**
     * Set the value of malOclu
     *
     * @return  self
     */ 
    public function setMalOclu($malOclu)
    {
        $this->malOclu = $malOclu;

        return $this;
    }

    /**
     * Get the value of fluorosis
     */ 
    public function getFluorosis()
    {
        return $this->fluorosis;
    }

    /**
     * Set the value of fluorosis
     *
     * @return  self
     */ 
    public function setFluorosis($fluorosis)
    {
        $this->fluorosis = $fluorosis;

        return $this;
    }

    /**
     * Get the value of totalPlaca
     */ 
    public function getTotalPlaca()
    {
        return $this->totalPlaca;
    }

    /**
     * Set the value of totalPlaca
     *
     * @return  self
     */ 
    public function setTotalPlaca($totalPlaca)
    {
        $this->totalPlaca = $totalPlaca;

        return $this;
    }

    /**
     * Get the value of totalCalc
     */ 
    public function getTotalCalc()
    {
        return $this->totalCalc;
    }

    /**
     * Set the value of totalCalc
     *
     * @return  self
     */ 
    public function setTotalCalc($totalCalc)
    {
        $this->totalCalc = $totalCalc;

        return $this;
    }

    /**
     * Get the value of totalGin
     */ 
    public function getTotalGin()
    {
        return $this->totalGin;
    }

    /**
     * Set the value of totalGin
     *
     * @return  self
     */ 
    public function setTotalGin($totalGin)
    {
        $this->totalGin = $totalGin;

        return $this;
    }
}