<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class DiagnosticosModel
{
    private $idOdo;
    private $diagnostico;
    private $idCie;
    private $tipo;

    public function __construct() {
        
    }
    public function saveWithTransaction()
    {
        DB::insert('insert into diagnosticos(id_odo,diagnostico,id_cie,tipo)
        values(?,?,?,?)',[
        $this->idOdo,
        $this->diagnostico,
        $this->idCie,
        $this->tipo
        ]);
    }
    
    public function saveTrasactionFromArray($pdo,$diagnosticos,$idOdo)
    {
        foreach ($diagnosticos as $diag) {
            $this->from($diag);
            $this->idOdo=$idOdo;
            $this->diagnosticosModel->saveWithTransaction($pdo);
        }
    }
    
    public function getPorIdOdo($idOdo){
        return DB::select('select d.id_odo as idOdo,d.diagnostico,
        c.nombre as cie,
        d.tipo
        from diagnosticos d inner join cie c on
        c.id=d.id_cie
        where id_odo = ?', [$idOdo]);
    }
    
    public function from($array){
        //$this->idOdo=$array['idOdo'];
        $this->diagnostico=$array['descripcion'];
        $this->idCie=$array['idCie'];
        $this->tipo=$array['tipo'];
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
     * Get the value of diagnostico
     */ 
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    /**
     * Set the value of diagnostico
     *
     * @return  self
     */ 
    public function setDiagnostico($diagnostico)
    {
        $this->diagnostico = $diagnostico;

        return $this;
    }

    /**
     * Get the value of idCie
     */ 
    public function getIdCie()
    {
        return $this->idCie;
    }

    /**
     * Set the value of idCie
     *
     * @return  self
     */ 
    public function setIdCie($idCie)
    {
        $this->idCie = $idCie;

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
}