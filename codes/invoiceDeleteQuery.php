<?php
session_start();
include_once('db_connection.php');

if (isset($_GET['InvoiceNumber'])) {
    $invoiceNumber = $_GET['InvoiceNumber'];

    $deleteSql = "DELETE FROM invoice WHERE InvoiceNumber = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param('s', $invoiceNumber);
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Invoice deleted successfully';
    } else {
        $_SESSION['error'] = 'Something went wrong in deleting the invoice';
    }
} else {
    $_SESSION['error'] = 'Select an invoice to delete';
}

header('location: invoice.php');
?>