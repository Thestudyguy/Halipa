<?php 

session_start();
include_once('db_connection.php');

if (strlen($_SESSION['damsid']) == 0) {
    header('location:logout.php');
    exit();
}

if (isset($_POST['addinvoice'])) {
    $invoiceNumber = generateInvoiceNumber();
    $invoiceDate = $_POST['DateInvoiced'];
    $dueDate = $_POST['DueDate'];
    $patientName = $_POST['SKU'];
    $serviceId = $_POST['specialization'];

    $sql = "INSERT INTO Invoice (InvoiceNumber, InvoiceDate, InvoiceDueDate, PatientName, Service) VALUES ('$invoiceNumber', '$invoiceDate', '$dueDate', '$patientName', '$serviceId')";

    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Invoice created successfully';
    } else {
        $_SESSION['error'] = 'Something went wrong while creating the invoice';
    }

    header('location: invoice.php');
    exit();
}
?>