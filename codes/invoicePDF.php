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
    
    // Convert InvoiceDate to a formatted date (Month Day, Year)
    $formattedInvoiceDate = date('F j, Y', strtotime($data['InvoiceDate']));
    
    // Add content to the PDF
    $invoiceDateContent = sprintf('Invoice Date: %s (%s)', $data['InvoiceDate'], $formattedInvoiceDate);
    $pdf->Cell(0, 10, $invoiceDateContent, 0, 1);
    $pdf->Cell(0, 10, 'Invoice Number: ' . $data['InvoiceNumber'], 0, 1);
    $pdf->Cell(0, 10, 'Patient Name: ' . $data['PatientName'], 0, 1);
    $pdf->Cell(0, 10, 'Service: ' . $data['Specialization'], 0, 1);
    $pdf->Cell(0, 10, 'Price: ' . $data['Price'], 0, 1);
    
    header('Content-Disposition: attachment; filename="'.$data['PatientName'].'-Invoice.pdf"');
    $pdf->Output($data['PatientName'].'-Invoice.pdf', 'I');
}
?>
