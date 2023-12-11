<?php
session_start();
include_once('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit'])) {
    $id = $_POST['ID'];
    $fullName = $_POST['editfullname'];
    $mobileNumber = $_POST['editNumber'];
    $email = $_POST['editemail'];
    $password = $_POST['password'];
    $access = $_POST['editaccess'];

    $sql = "UPDATE tbldoctor SET FullName = '$fullName', MobileNumber = '$mobileNumber', Email = '$email', Password = '$password', Access = '$access' WHERE ID = '$id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Doctor information updated successfully';
        header("Location: accounts.php");
        exit();
    } else {
        $_SESSION['error'] = 'Something went wrong in updating doctor information';
        die("Error: " . mysqli_error($conn));
    }
}

header("Location: accounts.php");
exit();
?>
