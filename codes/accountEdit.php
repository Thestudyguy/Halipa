<?php
session_start();

include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $id = $_POST['ID'];
    $fullName = $_POST['editfullname'];
    $mobileNumber = $_POST['editNumber'];
    $email = $_POST['editemail'];
    $password = $_POST['password'];
    $access = $_POST['editaccess'];


    try {
        $sql = "UPDATE tbldoctor SET FullName = ?, MobileNumber = ?, Email = ?, Password = ?, Access = ? WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssi', $fullName, $mobileNumber, $email, $password, $access, $id);
        $stmt->execute();

        $_SESSION['success'] = 'Doctor information updated successfully';
        header("Location: accounts.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        $_SESSION['error'] = 'Something went wrong in updating doctor information';
        die("Error: " . $e->getMessage());
    }
}

header("Location: accounts.php");
exit();
?>
