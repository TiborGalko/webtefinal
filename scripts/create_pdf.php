<?php

require_once "../tcpdf/config/tcpdf_config.php";
require_once "../tcpdf/tcpdf.php";
include_once "../db/vykonydb.php";

session_start();

if(isset($_SESSION['user_id'])) {
    outputPdf($_SESSION['user_id']);
}

function outputPdf($user_id)
{
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('webtefinal');
    $pdf->SetTitle('Tabuľka výkonov');
    $pdf->SetSubject('');
    $pdf->SetKeywords('');

// remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set font
    $pdf->SetFont('dejavusans', '', 10);

// add a page
    $pdf->AddPage();

    $html = '<h2>Tabuľka výkonov</h2>
<table border="1" cellpadding="4">
    <thead>
        <tr>
            <th>Počet kilometrov</th>
            <th>Deň</th>
            <th>Začiatok tréningu</th>
            <th>Koniec tréningu</th>
            <th>GPS štart</th>
            <th>GPS cieľ</th>
            <th>Hodnotenie</th>
            <th>Poznámka</th>
            <th>Priemerná rýchlosť</th>
        </tr>
    </thead>
    <tbody>' .
        getVykonyAndPriemerByUserId($user_id) .
        '</tbody>
    </table>';

    $pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
    $pdf->lastPage();

//Close and output PDF document
    $pdf->Output('tabulka.pdf', 'I');
}