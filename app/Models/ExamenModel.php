<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class ExamenModel 
{
    private $id;//Primary key
    private $idOdo;
    private $descripcion;
    private $detalles;

    public function __construct()
    {
        
    }

    public function saveWithTransaction()
    {
        //General
        $id=DB::table('examen')->insertGetId([
            'id_odo'=>$this->idOdo,
            'descripcion'=>$this->descripcion
        ]);
        //Detalles
        foreach ($this->detalles as $value) {
            DB::insert('insert into examen_detalles (id_exa,id_pat) values (?, ?)', [$id, $value['id']]);
        }
    }
    

    public function getExamen($idOdo)
    {
        $result=DB::selectOne('select * from examen where id_odo=?', [$idOdo]);
        $idExa=$result->id;
        $detalles=$this->getExamenDetalles($idExa);
        return ['general'=>$result,'detalles'=>$detalles];
    }

    private function getExamenDetalles($idExa)
    {
        return DB::select('select po.nombre
        from examen_detalles ed inner join patologias_opciones po
        on po.id=ed.id_pat 
        where ed.id_exa=?
        ', [
            $idExa
        ]);
    }

    public function setData($data)
    {
        $this->descripcion=$data['descripcion'];
        $this->detalles=$data['detalles'];
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
