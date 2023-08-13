<?php
session_start();
include_once('db_connection.php');

if (isset($_GET['Patientid'])) {
    $patient_id = $_GET['Patientid'];

    // Check if there are corresponding records in the patient_tools table
    $check_sql = "SELECT COUNT(*) as total FROM patient_tools WHERE patient_id = '$patient_id'";
    $result = $conn->query($check_sql);
    $row = $result->fetch_assoc();
    $total_patient_tools = $row['total'];

    if ($total_patient_tools > 0) {
        // If there are records in the patient_tools table, delete them first
        $delete_patient_tools_sql = "DELETE FROM patient_tools WHERE patient_id = '$patient_id'";
        if ($conn->query($delete_patient_tools_sql)) {
            // After deleting patient_tools, delete the patient record
            $delete_patient_sql = "DELETE FROM patient WHERE Patientid = '$patient_id'";
            if ($conn->query($delete_patient_sql)) {
                $_SESSION['success'] = 'Patient record deleted successfully';
            } else {
                $_SESSION['error'] = 'Something went wrong in deleting Patient record';
            }
        } else {
            $_SESSION['error'] = 'Something went wrong in deleting patient_tools';
        }
    } else {
        // If there are no patient_tools records, directly delete the patient record
        $delete_patient_sql = "DELETE FROM patient WHERE Patientid = '$patient_id'";
        if ($conn->query($delete_patient_sql)) {
            $_SESSION['success'] = 'Patient record deleted successfully';
        } else {
            $_SESSION['error'] = 'Something went wrong in deleting Patient record';
        }
    }
} else {
    $_SESSION['error'] = 'Select patient to delete first';
}

header('location: patient.php');
?>
