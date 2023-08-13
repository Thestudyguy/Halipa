<?php
include("db_connection.php");
try {
    if (!isset($_POST['searchPatient_name'])) {
        throw new Exception('Search term not provided.');
    }
    $term = $_POST['searchPatient_name'];
    $escaped_term = mysqli_real_escape_string($conn, $term);
    $sql = "SELECT patientName FROM patient WHERE patientName LIKE '$escaped_term%'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        throw new Exception('Error executing the database query.');
    }
    $output = '';
    while ($data = mysqli_fetch_array($result)) {
        $output .= "<li>".$data['patientName']."</li>";
    }
    echo $output;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
