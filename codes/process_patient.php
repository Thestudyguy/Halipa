<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['damsid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $patient_id = $_POST['patient_id'];
    $tools = $_POST['tools'];
    $tool_quantities = $_POST['tool_quantity'];
    $services = isset($_POST['services']) ? $_POST['services'] : [];
    $randomID = rand(100000, 999999);
    $patientName = $_POST['patientName'];
    $currentDate = date("Y-m-d");
    $dueDate = date("Y-m-d", strtotime($currentDate . " + 7 days"));
    $defaultStatus = "Pending";
try {
    $dbh->beginTransaction();
foreach ($tools as $tool_id) {
            $quantity = $tool_quantities[$tool_id];
            $randomIDInvoice = rand(100000, 999999);

            $sqlDeductQuantity = "UPDATE add_medicine SET quantity = quantity - :quantity WHERE id = :tool_id";
            $stmtDeductQuantity = $dbh->prepare($sqlDeductQuantity);
            $stmtDeductQuantity->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmtDeductQuantity->bindParam(':tool_id', $tool_id, PDO::PARAM_INT);
            $stmtDeductQuantity->execute();

            $sqlInsertTool = "INSERT INTO patient_tools (patient_tool_id, patient_id, tool_id, quantity, service, ID) 
            VALUES (NULL, :patient_id, :tool_id, :quantity, :service, :randomID)";
            $queryInsertTool = $dbh->prepare($sqlInsertTool);
            $queryInsertTool->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
            $queryInsertTool->bindParam(':tool_id', $tool_id, PDO::PARAM_INT);
            $queryInsertTool->bindParam(':quantity', $quantity, PDO::PARAM_INT);

            $serviceString = implode(",", $services);
            $queryInsertTool->bindParam(':service', $serviceString, PDO::PARAM_STR);

            $queryInsertTool->bindParam(':randomID', $randomID, PDO::PARAM_INT);

            $queryInsertTool->execute();
            
           
        }
        $sqlInsertInvoice = "INSERT INTO invoice (InvoiceNumber, InvoiceDate, InvoiceDueDate, PatientName, Service) 
        VALUES (:randomIDInvoice, :date, :dueDate, :patientName, :service)";
$queryInsertInvoice = $dbh->prepare($sqlInsertInvoice);
$queryInsertInvoice->bindParam(':randomIDInvoice', $randomIDInvoice, PDO::PARAM_INT);
$queryInsertInvoice->bindParam(':date', $currentDate, PDO::PARAM_STR);
$queryInsertInvoice->bindParam(':dueDate', $dueDate, PDO::PARAM_STR);
$queryInsertInvoice->bindParam(':patientName', $patientName, PDO::PARAM_STR);
$serviceString = implode(",", $services);
$queryInsertInvoice->bindParam(':service', $serviceString, PDO::PARAM_STR);

$queryInsertInvoice->execute();
//insert into sales_report table
$sqlInsertSalesReport = "INSERT INTO sales_report (ID, Date, Name, Service) 
VALUES (:randomID, :date, :patientName, :service)";
$queryInsertSalesReport = $dbh->prepare($sqlInsertSalesReport);
$queryInsertSalesReport->bindParam(':randomID', $randomID, PDO::PARAM_INT);
$queryInsertSalesReport->bindParam(':date', $currentDate, PDO::PARAM_STR);
$queryInsertSalesReport->bindParam(':patientName', $patientName, PDO::PARAM_STR);
$queryInsertSalesReport->bindParam(':service', $serviceString, PDO::PARAM_STR);
$queryInsertSalesReport->execute();
        $dbh->commit();
} catch (PDOException $e) {
    $dbh->rollBack();
    echo "Error: " . $e->getMessage();
}
        
        echo '<script>alert("Patient information saved successfully")</script>';
        echo "<script>window.location.href ='patient.php'</script>";
    }
}
?>
