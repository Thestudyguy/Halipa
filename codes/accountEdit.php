<?php
session_start();

// Include the database connection file
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    // Get the form data
    $id = $_POST['ID'];
    $fullName = $_POST['editfullname'];
    $mobileNumber = $_POST['editNumber'];
    $email = $_POST['editemail'];
    $password = $_POST['password'];
    $access = $_POST['editaccess'];

    // Validate and sanitize the input data (you should add proper validation and sanitization here)

    try {
        // Update the doctor record in the database based on the provided data
        $sql = "UPDATE tbldoctor SET FullName = ?, MobileNumber = ?, Email = ?, Password = ?, Access = ? WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssi', $fullName, $mobileNumber, $email, $password, $access, $id);
        $stmt->execute();

        // Set success message and redirect to a success page
        $_SESSION['success'] = 'Doctor information updated successfully';
        header("Location: accounts.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        // Handle database errors and show an error message
        $_SESSION['error'] = 'Something went wrong in updating doctor information';
        die("Error: " . $e->getMessage());
    }
}

// If the script reaches here without redirection, there was no form submission.
// Redirect back to the previous page or any other appropriate action.
header("Location: accounts.php");
exit();
?>
