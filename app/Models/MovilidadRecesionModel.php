<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class MovilidadRecesionModel 
{
    private $id;
    private $idOdontog;//Id del odontograma
    private $tipo;
    private $valor;
    private $pos;

    public function __construct()
    {
        
    }
    public function saveWithTransaction()
    {
        DB::insert('Insert into movilidad_recesion(id_odontog,tipo,valor,pos)
        values(?,?,?,?)',[
            $this->idOdontog,
            $this->tipo,
            $this->valor,
            $this->pos
        ]);
    }

    
    public function from($array)
    {
        //$this->id=$array['id'];
        //$this->idOdontog=$array['idOdontog'];
        $this->tipo=$array['tipo'];
        $this->valor=$array['valor'];
        $this->pos=$array['pos'];
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
     * Get the value of idOdontog
     */
    public function getIdOdontog()
    {
        return $this->idOdontog;
    }

    /**
     * Set the value of idOdontog
     *
     * @return  self
     */
    public function setIdOdontog($idOdontog)
    {
        $this->idOdontog = $idOdontog;

        return $this;
    }

    /**
     * Get the value of tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of valor
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set the value of valor
     *
     * @return  self
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get the value of pos
     */
    public function getPos()
    {
        return $this->pos;
    }

    /**
     * Set the value of pos
     *
     * @return  self
     */
    public function setPos($pos)
    {
        $this->pos = $pos;

        return $this;
    }
}
