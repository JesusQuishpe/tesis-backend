<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class DientesModel 
{
    private $id;
    private $idOdontog;
    private $tipo;
    private $numDiente;
    private $pos;
    private $dienteTop;
    private $dienteLeft;
    private $dienteRight;
    private $dienteBottom;
    private $dienteCenter;
    private $simbologia;

    public function __construct() {
        
    }
    
    public function saveWithTransaction()
    {
        DB::insert('Insert into dientes_detalles(id_odontog,tipo,num_diente,pos,diente_top,
        diente_left,diente_right,diente_center,diente_bottom,simbologia)
        values(?,?,?,?,?,?,?,?,?,?)',[
            $this->idOdontog,
            $this->tipo,
            $this->numDiente,
            $this->pos,
            $this->dienteTop,
            $this->dienteLeft,
            $this->dienteRight,
            $this->dienteCenter,
            $this->dienteBottom,
            $this->simbologia
        ]);
    }

    public function save(){

    }
    public function getAll(){

    }
    public function get($id){

    }
    public function delete($id){

    }
    public function update(){

    }
    public function from($array){
        //$this->id=$array['id'];
        //$this->idOdontog=$array['idOdontog'];
        $this->tipo=$array['tipo'];
        $this->numDiente=$array['numDiente'];
        $this->pos=$array['pos'];
        $this->dienteTop=$array['dienteTop'];
        $this->dienteLeft=$array['dienteLeft'];
        $this->dienteRight=$array['dienteRight'];
        $this->dienteCenter=$array['dienteCenter'];
        $this->dienteBottom=$array['dienteBottom'];
        $this->simbologia=$array['simbologia'];
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
     * Get the value of numDiente
     */ 
    public function getNumDiente()
    {
        return $this->numDiente;
    }

    /**
     * Set the value of numDiente
     *
     * @return  self
     */ 
    public function setNumDiente($numDiente)
    {
        $this->numDiente = $numDiente;

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

    /**
     * Get the value of dienteTop
     */ 
    public function getDienteTop()
    {
        return $this->dienteTop;
    }

    /**
     * Set the value of dienteTop
     *
     * @return  self
     */ 
    public function setDienteTop($dienteTop)
    {
        $this->dienteTop = $dienteTop;

        return $this;
    }

    /**
     * Get the value of dienteLeft
     */ 
    public function getDienteLeft()
    {
        return $this->dienteLeft;
    }

    /**
     * Set the value of dienteLeft
     *
     * @return  self
     */ 
    public function setDienteLeft($dienteLeft)
    {
        $this->dienteLeft = $dienteLeft;

        return $this;
    }

    /**
     * Get the value of dienteRight
     */ 
    public function getDienteRight()
    {
        return $this->dienteRight;
    }

    /**
     * Set the value of dienteRight
     *
     * @return  self
     */ 
    public function setDienteRight($dienteRight)
    {
        $this->dienteRight = $dienteRight;

        return $this;
    }

    /**
     * Get the value of dienteBottom
     */ 
    public function getDienteBottom()
    {
        return $this->dienteBottom;
    }

    /**
     * Set the value of dienteBottom
     *
     * @return  self
     */ 
    public function setDienteBottom($dienteBottom)
    {
        $this->dienteBottom = $dienteBottom;

        return $this;
    }

    /**
     * Get the value of dienteCenter
     */ 
    public function getDienteCenter()
    {
        return $this->dienteCenter;
    }

    /**
     * Set the value of dienteCenter
     *
     * @return  self
     */ 
    public function setDienteCenter($dienteCenter)
    {
        $this->dienteCenter = $dienteCenter;

        return $this;
    }

    /**
     * Get the value of simbologia
     */ 
    public function getSimbologia()
    {
        return $this->simbologia;
    }

    /**
     * Set the value of simbologia
     *
     * @return  self
     */ 
    public function setSimbologia($simbologia)
    {
        $this->simbologia = $simbologia;

        return $this;
    }
}