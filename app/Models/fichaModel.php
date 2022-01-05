<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class FichaModel
{
    //Variables model
    private $odontologiaModel;
    private $antecedenteModel;
    private $examenModel;
    private $indicadoresModel;
    private $indicesModel;
    private $planDiagnostico;
    private $diagnosticosModel;
    private $tratamientosModel;
    private $odontogramaModel;
    //Variables
    private $diagnosticos; //Array de la clase DiagnosticoModel
    private $tratamientos;
    //Constructor
    public function __construct()
    {

        $this->odontologiaModel = new OdontologiaModel();
        $this->antecedenteModel = new  AntecedenteModel();
        $this->examenModel = new ExamenModel();
        $this->indicadoresModel = new IndicadoresModel();
        $this->indicesModel = new IndicesModel();
        $this->planDiagnostico = new PlanDiagnosticoModel();
        $this->diagnosticosModel = new DiagnosticosModel();
        $this->tratamientosModel = new TratamientosModel();
        $this->odontogramaModel = new OdontogramaModel();
        $this->diagnosticos = [];
        $this->tratamientos = [];
    }

    /**
     * Metodo que guarda toda la ficha completa
     */
    public function save()
    {
        //Agregar datos a tabla odontologia
        $idOdo = $this->odontologiaModel->terminarAtencion();
        //Agregar antecedentes
        $this->antecedenteModel->setIdOdo($idOdo);
        $this->antecedenteModel->saveWithTransaction();
        //Agregar examen del sistema estomatognatico
        $this->examenModel->setIdOdo($idOdo);
        $this->examenModel->saveWithTransaction();
        //Agregar indicadores de salud bucal
        $this->indicadoresModel->setIdOdo($idOdo);
        $this->indicadoresModel->saveWithTransaction();
        //Agregar indices cpo
        $this->indicesModel->setIdOdo($idOdo);
        $this->indicesModel->saveWithTransaction();
        //Agregar plan de diagnosticos
        $this->planDiagnostico->setIdOdo($idOdo);
        $this->planDiagnostico->saveWithTransaction();
        //Agregar diagnosticos
        foreach ($this->diagnosticos as $diag) {
            $diag->setIdOdo($idOdo);
            $diag->saveWithTransaction();
        }
        //Agregar tratamientos
        foreach ($this->tratamientos as $trat) {
            $trat->setIdOdo($idOdo);
            $trat->saveWithTransaction();
        }
        //Agregar odontograma
        $this->odontogramaModel->setIdOdo($idOdo);
        $this->odontogramaModel->saveWithTransaction();
        //Actualizar campo estadisticas en citas
        DB::update("UPDATE citas c  inner join enfermeria e on e.id = c.id 
        inner join odontologia o on o.id_enf=e.ide
        set c.estadisticas='o'  where o.id_odo=?",[
            $this->odontologiaModel->getIdOdo()
        ]);
    }


    public function fueAtendidoOdontologia($idOdo)
    {
        return DB::selectOne('SELECT id_odo from  odontologia  where id_odo=? and atendido=1', [$idOdo]);
    }

    public function getDatosPacienteEnfermeria($idOdo)
    {
        return DB::selectOne('SELECT e.id,i.cedula,i.nombres,i.apellidos,i.sexo,
                        e.peso,e.estatura,e.temperatura,e.presion
                        from odontologia o 
                        inner join enfermeria e on e.ide=o.id_enf
                        inner join citas c on c.id=e.id
                        inner join ingresar i on i.num=c.num
                        where o.id_odo=?', [$idOdo]);
    }

    public function getFichaPaciente($idOdo)
    {
        $ficha=[];
        $datosPaciente=$this->odontologiaModel->getPorIdOdo($idOdo);
        $antecedentes=$this->antecedenteModel->getAntecedentes($idOdo);
        $examen=$this->examenModel->getExamen($idOdo);
        $indicadores=$this->indicadoresModel->getPorIdOdo($idOdo);
        $indices=$this->indicesModel->getPorIdOdo($idOdo);
        $planDiagnostico=$this->planDiagnostico->getPlan($idOdo);
        $diagnosticos=$this->diagnosticosModel->getPorIdOdo($idOdo);
        $tratamientos=$this->tratamientosModel->getPorIdOdo($idOdo);
        $odontograma=$this->odontogramaModel->getPorIdOdo($idOdo);

        $ficha['informacion']=$datosPaciente;
        $ficha['antecedentes']=$antecedentes;
        $ficha['examen']=$examen;
        $ficha['indicadores']=$indicadores;
        $ficha['indices']=$indices;
        $ficha['planDiagnostico']=$planDiagnostico;
        $ficha['diagnosticos']=$diagnosticos;
        $ficha['tratamientos']=$tratamientos;
        $ficha['odontograma']=$odontograma;
        
        return $ficha;
    }












    /**
     * Get the value of odontologiaModel
     */
    public function getOdontologiaModel()
    {
        return $this->odontologiaModel;
    }

    /**
     * Set the value of odontologiaModel
     *
     * @return  self
     */
    public function setOdontologiaModel($odontologiaModel)
    {
        $this->odontologiaModel = $odontologiaModel;

        return $this;
    }

    /**
     * Get the value of antecedenteModel
     */
    public function getAntecedenteModel()
    {
        return $this->antecedenteModel;
    }

    /**
     * Set the value of antecedentesModel
     *
     * @return  self
     */
    public function setAntecedenteModel($antecedenteModel)
    {
        $this->antecedenteModel = $antecedenteModel;

        return $this;
    }

    /**
     * Get the value of examenModel
     */
    public function getExamenModel()
    {
        return $this->examenModel;
    }

    /**
     * Set the value of examenModel
     *
     * @return  self
     */
    public function setExamenModel($examenModel)
    {
        $this->examenModel = $examenModel;

        return $this;
    }

    /**
     * Get the value of indicadoresModel
     */
    public function getIndicadoresModel()
    {
        return $this->indicadoresModel;
    }

    /**
     * Set the value of indicadoresModel
     *
     * @return  self
     */
    public function setIndicadoresModel($indicadoresModel)
    {
        $this->indicadoresModel = $indicadoresModel;

        return $this;
    }

    /**
     * Get the value of indicesModel
     */
    public function getIndicesModel()
    {
        return $this->indicesModel;
    }

    /**
     * Set the value of indicesModel
     *
     * @return  self
     */
    public function setIndicesModel($indicesModel)
    {
        $this->indicesModel = $indicesModel;

        return $this;
    }

    /**
     * Get the value of planDiagnostico
     */
    public function getPlanDiagnostico()
    {
        return $this->planDiagnostico;
    }

    /**
     * Set the value of planDiagnostico
     *
     * @return  self
     */
    public function setPlanDiagnostico($planDiagnostico)
    {
        $this->planDiagnostico = $planDiagnostico;

        return $this;
    }

    /**
     * Get the value of diagnosticosModel
     */
    public function getDiagnosticosModel()
    {
        return $this->diagnosticosModel;
    }

    /**
     * Set the value of diagnosticosModel
     *
     * @return  self
     */
    public function setDiagnosticosModel($diagnosticosModel)
    {
        $this->diagnosticosModel = $diagnosticosModel;

        return $this;
    }

    /**
     * Get the value of tratamientosModel
     */
    public function getTratamientosModel()
    {
        return $this->tratamientosModel;
    }

    /**
     * Set the value of tratamientosModel
     *
     * @return  self
     */
    public function setTratamientosModel($tratamientosModel)
    {
        $this->tratamientosModel = $tratamientosModel;

        return $this;
    }

    /**
     * Get the value of odontogramaModel
     */
    public function getOdontogramaModel()
    {
        return $this->odontogramaModel;
    }

    /**
     * Set the value of odontogramaModel
     *
     * @return  self
     */
    public function setOdontogramaModel($odontogramaModel)
    {
        $this->odontogramaModel = $odontogramaModel;

        return $this;
    }

    /**
     * Get the value of tratamientos
     */
    public function getTratamientos()
    {
        return $this->tratamientos;
    }

    /**
     * Set the value of tratamientos
     *
     * @return  self
     */
    public function setTratamientos($tratamientos)
    {
        $this->tratamientos = $tratamientos;

        return $this;
    }

    /**
     * Get the value of diagnosticos
     */
    public function getDiagnosticos()
    {
        return $this->diagnosticos;
    }

    /**
     * Set the value of diagnosticos
     *
     * @return  self
     */
    public function setDiagnosticos($diagnosticos)
    {
        $this->diagnosticos = $diagnosticos;

        return $this;
    }
}
