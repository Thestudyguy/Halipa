<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    // Get form data
    $fullName = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $access = $_POST['access'];

    // Perform a database check to see if the doctor with the same email already exists
    $sql_check_email = "SELECT COUNT(*) AS count FROM tbldoctor WHERE Email = :email";
    $query_check_email = $dbh->prepare($sql_check_email);
    $query_check_email->bindParam(':email', $email, PDO::PARAM_STR);
    $query_check_email->execute();
    $result_check_email = $query_check_email->fetch(PDO::FETCH_ASSOC);

    if ($result_check_email['count'] > 0) {
        // Email already exists, set an error message and redirect back to the form page
        $_SESSION['error'] = "Doctor with the same email already exists!";
        header("Location: accounts.php");
        exit;
    }

    // Perform database insert operation (assuming you have a database connection)
    try {
        $sql = "INSERT INTO tbldoctor (FullName, Email, Password, Access) VALUES (:fullName, :email, :password, :access)";
        $query = $dbh->prepare($sql);

        // Bind parameters
        $query->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':access', $access, PDO::PARAM_STR);

        // Execute the query
        $query->execute();

        // Set success message in session
        $_SESSION['success'] = "Doctor added successfully!";

        // Redirect to the success page (e.g., accounts.php)
        header("Location: accounts.php");
        exit;
    } catch (PDOException $e) {
        // Handle any database errors
        $_SESSION['error'] = "Error: " . $e->getMessage();
        // Redirect back to the form page to show the error
        header("Location: accounts.php");
        exit;
    }
}
?>
