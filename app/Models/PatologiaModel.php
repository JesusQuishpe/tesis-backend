<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class PatologiaModel{
    private $id;
    private $nombre;

    public function __construct() {
        
    }

    public function getAll()
    {   
        return DB::select('select * from patologias_opciones', []);
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
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
}