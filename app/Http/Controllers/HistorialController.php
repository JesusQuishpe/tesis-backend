<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Reportes\HistorialReporte;
use App\Reportes\LaboratorioReporte;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->has('texto')) {
            $model = new Historial();
            $datos = $model->obtenerHistorial($request->input('texto'));

            return view('laboratorio.historial.index', ['datos' => $datos]);
        }

        return view('laboratorio.historial.index');
    }
    public function ver(Request $request, $idTipoExamen, $idExamen)
    {
        $model = new Historial();

        $datos = $model->verHistorial(intval($idTipoExamen), intval($idExamen));
        //dd($datos);
        //Crear reporte
        $reporte = new LaboratorioReporte();
        $reporte->SetCreator(PDF_CREATOR);
        $reporte->SetAuthor('Nicola Asuni');
        $reporte->SetTitle('HISTORIAL');
        $reporte->SetSubject('TCPDF Tutorial');
        $reporte->SetKeywords('TCPDF, PDF, example, test, guide');

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

        $reporte->Header();

        $reporte->Body($datos[0],intval($idTipoExamen));

        //dd(asset('images/png/prefectura-logo.png'));
        $reporte->Output('Historial.pdf', 'I');
    }
}
