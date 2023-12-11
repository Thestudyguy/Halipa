<?php
require_once('C:\xampp\htdocs\halipa\TCPDF-main/tcpdf.php');

if (isset($_POST['data'])) {
    $data = json_decode($_POST['data'], true);

    if ($data === null) {
        die('Error decoding JSON data');
    }

    // Retrieve the date range
    session_start();
    $dateFrom = $_SESSION['date_from'];
    $dateTo = $_SESSION['date_to'];
    $formatDateFrom = date('F j, Y', strtotime($dateFrom));
    $formatDateTo = date('F j, Y', strtotime($dateTo));
    // Create a new PDF instance
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Halipa Dental Clinic');
    $pdf->SetTitle('Sales Report PDF');
    $pdf->SetSubject('Sales Report Details');

    $pdf->AddPage();

    $pdf->SetFont('times', '', 12);

    $pdf->Cell(0, 10, 'Sales at ' . $formatDateFrom . ' to ' . $formatDateTo, 0, 1, 'C');
    $pdf->Ln();

    // Add data to the PDF
    $pdf->Cell(0, 10, 'Sales Report', 0, 1, 'C');

    $totalSales = 0;

    foreach ($data as $row) {
        $pdf->Cell(40, 10, 'Service: ' . $row['servicename']);
        $pdf->Cell(40, 10, 'Price: ' . $row['price']);
        $pdf->Cell(40, 10, 'Total Patients: ' . $row['totalPatients']);
        $pdf->Cell(40, 10, 'Total Sales: ' . $row['totalSales']);
        $pdf->Ln();

        $totalSales += $row['totalSales'];
    }

    $pdf->Ln();
    $pdf->Cell(0, 10, 'Total Sales: ' . $totalSales, 0, 1, 'R');

    // Output the PDF
    $pdf->Output('sales_report.pdf', 'I');
} else {
    echo 'Data not received';
}
?>
