<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use JsonSerializable;

class IndicadorDetalleModel implements JsonSerializable
{
    private $idIndsb;
    private $numPieza1;
    private $numPieza2;
    private $numPieza3;
    private $numPlac;
    private $numCalc;
    private $numGin;

    public function __construct()
    {
    }

    public function saveWithTransaction()
    {
        DB::insert('Insert into indicadores_detalles(id_indsb,num_pieza1,num_pieza2,num_pieza3,num_placa,num_calc,num_gin)
        values (?,?,?,?,?,?,?)', [
            $this->idIndsb,
            $this->numPieza1,
            $this->numPieza2,
            $this->numPieza3,
            $this->numPlac,
            $this->numCalc,
            $this->numGin
        ]);
    }
    public function save()
    {
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
    public function from($array)
    {

        $this->numPieza1 = $array['numPieza1'];
        $this->numPieza2 = $array['numPieza2'];
        $this->numPieza3 = $array['numPieza3'];
        $this->numPlac = $array['numPlac'];
        $this->numCalc = $array['numCalc'];
        $this->numGin = $array['numGin'];
    }

    public function jsonSerialize()
    {
        return [
            'numPieza1'=>$this->numPieza1,
            'numPieza2'=>$this->numPieza2,
            'numPieza3'=>$this->numPieza3,
            'numPlac'=>$this->numPlac,
            'numCalc'=>$this->numCalc,
            'numGin'=>$this->numGin
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
     * Get the value of numPieza1
     */
    public function getNumPieza1()
    {
        return $this->numPieza1;
    }

    /**
     * Set the value of numPieza1
     *
     * @return  self
     */
    public function setNumPieza1($numPieza1)
    {
        $this->numPieza1 = $numPieza1;

        return $this;
    }

    /**
     * Get the value of numPieza2
     */
    public function getNumPieza2()
    {
        return $this->numPieza2;
    }

    /**
     * Set the value of numPieza2
     *
     * @return  self
     */
    public function setNumPieza2($numPieza2)
    {
        $this->numPieza2 = $numPieza2;

        return $this;
    }

    /**
     * Get the value of numPieza3
     */
    public function getNumPieza3()
    {
        return $this->numPieza3;
    }

    /**
     * Set the value of numPieza3
     *
     * @return  self
     */
    public function setNumPieza3($numPieza3)
    {
        $this->numPieza3 = $numPieza3;

        return $this;
    }

    /**
     * Get the value of numPlac
     */
    public function getNumPlac()
    {
        return $this->numPlac;
    }

    /**
     * Set the value of numPlac
     *
     * @return  self
     */
    public function setNumPlac($numPlac)
    {
        $this->numPlac = $numPlac;

        return $this;
    }

    /**
     * Get the value of numCalc
     */
    public function getNumCalc()
    {
        return $this->numCalc;
    }

    /**
     * Set the value of numCalc
     *
     * @return  self
     */
    public function setNumCalc($numCalc)
    {
        $this->numCalc = $numCalc;

        return $this;
    }

    /**
     * Get the value of numGin
     */
    public function getNumGin()
    {
        return $this->numGin;
    }

    /**
     * Set the value of numGin
     *
     * @return  self
     */
    public function setNumGin($numGin)
    {
        $this->numGin = $numGin;

        return $this;
    }
}
