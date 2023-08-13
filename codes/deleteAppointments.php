<?php
session_start();
include_once('db_connection.php');

if (isset($_GET['AppointmentNumber'])) {
    $appointmentNumber = $_GET['AppointmentNumber'];
    $selectSql = "SELECT * FROM tblappointment WHERE AppointmentNumber = ?";
    $stmt = $conn->prepare($selectSql);
    $stmt->bind_param('s', $appointmentNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();

    $deleteSql = "DELETE FROM tblappointment WHERE AppointmentNumber = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param('s', $appointmentNumber);
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Appointment Record Deleted successfully';
    } else {
        $_SESSION['error'] = 'Something went wrong in deleting record';
    }
} else {
    $_SESSION['error'] = 'Select an appointment to delete';
}

header('location: all-appointment.php');
?>
