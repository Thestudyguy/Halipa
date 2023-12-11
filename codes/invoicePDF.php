<?php
require_once('C:\xampp\htdocs\halipa\TCPDF-main/tcpdf.php');

if (isset($_POST['data'])) {
    $data = json_decode($_POST['data'], true);
    
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Invoice PDF');
    $pdf->SetSubject('Invoice Details');
    
    $pdf->AddPage();
    
    $pdf->SetFont('times', '', 12);
    $formattedInvoiceDate = date('F j, Y', strtotime($data['InvoiceDate']));
    
    
    $invoiceDateContent = sprintf('Invoice Date: %s (%s)', $data['InvoiceDate'], $formattedInvoiceDate);
    $pdf->SetFont('times', 14);
    $pdf->SetFont('times', 'B', 12);
    $pdf->Cell(0, 10, 'Halipa Dental Clinic Invoice', 0, 1, 'C',);
    $pdf->SetFont('times', '', 12);
    $pdf->Cell(0, 10, 'Dr.1, 2nd Flr, Barios bldg, New Pandan Panabo City, Davao del Norte ', 0, 1);
    $pdf->Cell(0, 10, 'Non-Vat Reg. TIN: 123-456-789', 'B', 0, 1);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(0, 10, 'Patient ', 0, 1);

    $pdf->SetX(15);
    $pdf->Cell(0, 10, 'Invoice Number: ' . $data['InvoiceNumber'], 0, 1);
    
    $pdf->SetX(15);
    $pdf->Cell(0, 10, 'Patient Name: ' . $data['PatientName'], 0, 1);
    
    $pdf->SetX(15);
    $pdf->SetFont('times', 'B', 12);
    $pdf->Cell(0, 10, $data['Specialization'], 0, 1);
    $pdf->SetFont('times', '', 12);
    
    $pdf->SetX(15);
    //$pdf->Cell(0, 10, 'Price: ' . $data['Price'], 0, 1);

    $pdf->SetX(15);
    $pdf->SetFont('times', 'B', 12);
    $pdf->Cell(0, 10, $invoiceDateContent, 0, 1);
    $pdf->SetFont('times', '', 12);
    $pdf->Ln();
$pdf->SetFont('times', '', 12);
$pdf->SetX($pdf->GetX() - 0);

$pdf->SetX(25);
$pdf->Cell(15, 10, 'No', 1);
$pdf->Cell(85, 10, 'Description', 1);
$pdf->Cell(30, 10, 'Price', 1);
$pdf->Cell(30, 10, 'Total', 1);
$pdf->Ln();

for ($i = 1; $i <= 7; $i++) {
    $pdf->SetX(25);
    $pdf->Cell(15, 10, '', 1);
    $pdf->Cell(85, 10, '' . '', 1);
    $pdf->Cell(30, 10, '', 1);
    $pdf->Cell(30, 10, '', 1);
    $pdf->Ln();
    
}
$pdf->SetX(25);
$pdf->Cell(100, 40, 'Notes:', 1);
$pdf->SetX(125);
$pdf->Cell(30, 10, 'Subtotal:',1);
$pdf->Cell(30, 10, '',1);
$pdf->Ln();
$pdf->SetX(125);
$pdf->Cell(30, 10, 'Tax:', 1);
$pdf->Cell(30, 10, '', 1);
$pdf->SetX($pdf->GetX() - 50);
$pdf->Ln();
$pdf->SetX(125);
$pdf->Cell(30, 10, 'Other:', 1);
$pdf->Cell(30, 10, '', 1);
$pdf->SetX($pdf->GetX() - 50);
$pdf->Ln();
$pdf->SetX(125);
$pdf->Cell(30, 10, 'Total:', 1);
$pdf->Cell(30, 10, $data['Price'], 1);
$pdf->SetX($pdf->GetX() - 50);
$pdf->Ln();

$pdf->Cell(0, 10, 'Thank you for trusting us with your health journey', 0, 1, 'C');

    header('Content-Disposition: attachment; filename="'.$data['PatientName'].'-Invoice.pdf"');
    $pdf->Output($data['PatientName'].'-Invoice.pdf', 'I');
}
?>
