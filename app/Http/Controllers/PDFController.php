<?php

namespace App\Http\Controllers;

use App\Models\AntecedentesOpcionesModel;
use App\Models\FichaModel;
use App\Models\OdontogramaLayout;
use App\Models\PatologiaModel;
use App\Reportes\HistorialReporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use TCPDF;

class PDFController extends Controller
{
    //
    public function pdf(Request $request, $idOdo)
    {
        // $idOdo = $request->input('idOdo');

        $model = new FichaModel();
        $data = $model->getFichaPaciente($idOdo);
        #---------------------------------------
        $informacion = $data['informacion'];
        $antecedenteOpcionesModel = new AntecedentesOpcionesModel();
        $antecedentes = $antecedenteOpcionesModel->getAll();
        $patologiaModel = new PatologiaModel();
        $patologias = $patologiaModel->getAll();


        $reporte = new HistorialReporte();
        // set document information

        $reporte->SetCreator(PDF_CREATOR);
        $reporte->SetAuthor('Nicola Asuni');
        $reporte->SetTitle('HISTORIAL');
        $reporte->SetSubject('TCPDF Tutorial');
        $reporte->SetKeywords('TCPDF, PDF, example, test, guide');
        // set default header data
        
        // set default header data
        $reporte->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Historial' . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $reporte->setFooterData(array(0, 64, 0), array(0, 64, 128));

        // set header and footer fonts
        $reporte->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $reporte->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $reporte->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $reporte->SetHeaderMargin(15);

        $reporte->SetMargins(10, 25, 10);
        

        //$reporte->SetFooterMargin(PDF_MARGIN_FOOTER);



        $reporte->InformacionPersonal($informacion);
        $reporte->Antecedentes($antecedentes, $data['antecedentes']['detalles'], $data['antecedentes']['general']->descripcion);
        $reporte->ExamenEstomatognatico($patologias, $data['examen']['detalles'], $data['examen']['general']->descripcion);
        $reporte->Odontograma($data['odontograma']['odontogramaImage']);
        $reporte->IndicadoresDeSaludBucal($data['indicadores']['general'], $data['indicadores']['detalles']);
        $reporte->Output('Historial.pdf', 'I');
    }
}
