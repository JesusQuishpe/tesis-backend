<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Patient;
use App\Reports\QRReport;
use Illuminate\Http\Request;
use TCPDF;

class QRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $patient = Patient::find($id);
        $company = Company::find(1);

        $pdf = new QRReport('L', 'mm', array(88.9, 50.8));
        // Set font
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->setAutoPageBreak(false);
        // set default header data
        // remove default header/footer
        //$pdf->setPrintHeader(false);
        //$pdf->setPrintFooter(false);
        // set header and footer fonts
        //$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        //$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

       // $pdf->SetHeaderMargin(0);

        $pdf->SetMargins(0, 0, 0);

        $pdf->Cuerpo($patient,null);

        $pdf->Output('QRPaciente.pdf', 'I');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
