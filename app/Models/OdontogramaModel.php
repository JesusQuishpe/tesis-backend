<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

require_once 'dientesModel.php';
require_once 'movilidadRecesionModel.php';
class OdontogramaModel 
{
    private $idOdontog;
    private $idOdo;
    private $odontogramaImage;
    private $dientes;
    private $movilidadRecesiones;
    
    public function __construct() {
        
    }

    public function saveWithTransaction()
    {
        //Primero guardamos en la tabla odontograma
        $id=DB::table('odontograma')->insertGetId([
            'id_odo'=>$this->idOdo,
            'odontograma_image'=>$this->odontogramaImage
        ]);
        
        //Agregamos los dientes
        foreach ($this->dientes as $diente) {
            $diente->setIdOdontog($id);
            $diente->saveWithTransaction();
        }
        //Agregamos movilidades y recesiones
        foreach ($this->movilidadRecesiones as $item) {
            $item->setIdOdontog($id);
            $item->saveWithTransaction();
        }
    }
    
    public function getUltimoOdontograma($cedula)
    {
        $odo=DB::selectOne('select o.id_odo as idOdo,o.id_odontog as idOdontog,o.odontograma_image as odontogramaImage 
        from odontograma o inner join odontologia od on
        od.id_odo=o.id_odo
        where od.fecha_consulta_clie=(select max(fecha_consulta_clie) from odontologia where cedula=?)', [$cedula]);

        if(!$odo)return false;

        $dientes=DB::select('select det.id,
        det.id_odontog as idOdontog,
        det.tipo,
        det.num_diente as numDiente,
        det.pos,
        det.diente_top as dienteTop,
        det.diente_left as dienteLeft,
        det.diente_right as dienteRight,
        det.diente_center as dienteCenter,
        det.diente_bottom as dienteBottom,
        det.simbologia
        from dientes_detalles det 
        where det.id_odontog=?', [$odo->idOdontog]);

        $recmovs=DB::select('select 
        mr.id,
        mr.id_odontog as idOdontog,
        mr.tipo,
        mr.valor,
        mr.pos
        from movilidad_recesion mr 
        where mr.id_odontog=?', [$odo->idOdontog]);

        $odontograma=[];
        $odontograma['odontogramaImage']=$odo->odontogramaImage;
        $odontograma['recmovs']=$recmovs;
        $odontograma['dientes']=$dientes;
       
        return $odontograma;
    }
    public function getPorIdOdo($idOdo)
    {
        $odo=DB::selectOne('select o.id_odo as idOdo,o.id_odontog as idOdontog,o.odontograma_image as odontogramaImage 
        from odontograma o 
        where o.id_odo=?', [$idOdo]);

        $dientes=DB::select('select det.id,
        det.id_odontog as idOdontog,
        det.tipo,
        det.num_diente as numDiente,
        det.pos,
        det.diente_top as dienteTop,
        det.diente_left as dienteLeft,
        det.diente_right as dienteRight,
        det.diente_center as dienteCenter,
        det.diente_bottom as dienteBottom,
        det.simbologia
        from dientes_detalles det 
        where det.id_odontog=?', [$odo->idOdontog]);

        $recmovs=DB::select('select 
        mr.id,
        mr.id_odontog as idOdontog,
        mr.tipo,
        mr.valor,
        mr.pos
        from movilidad_recesion mr 
        where mr.id_odontog=?', [$odo->idOdontog]);

        $odontograma=[];
        $odontograma['odontogramaImage']=$odo->odontogramaImage;
        $odontograma['recmovs']=$recmovs;
        $odontograma['dientes']=$dientes;
       
        return $odontograma;
    }

    public function from($array){
        $this->idOdontog=$array['idOdontog'];
        $this->idOdo=$array['idOdo'];
        $this->dientes=$array['dientes'];
        $this->movilidadRecesiones=$array['movilidadRecesiones'];
        $this->odontogramaImage=$array['odontogramaImage'];
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
     * Get the value of dientes
     */ 
    public function getDientes()
    {
        return $this->dientes;
    }

    /**
     * Set the value of dientes
     *
     * @return  self
     */ 
    public function setDientes($dientes)
    {
        $this->dientes = $dientes;

        return $this;
    }

    /**
     * Get the value of movilidadRecesiones
     */ 
    public function getMovilidadRecesiones()
    {
        return $this->movilidadRecesiones;
    }

    /**
     * Set the value of movilidadRecesiones
     *
     * @return  self
     */ 
    public function setMovilidadRecesiones($movilidadRecesiones)
    {
        $this->movilidadRecesiones = $movilidadRecesiones;

        return $this;
    }

    /**
     * Get the value of odontogramaImage
     */ 
    public function getOdontogramaImage()
    {
        return $this->odontogramaImage;
    }

    /**
     * Set the value of odontogramaImage
     *
     * @return  self
     */ 
    public function setOdontogramaImage($odontogramaImage)
    {
        $this->odontogramaImage = $odontogramaImage;

        return $this;
    }
}