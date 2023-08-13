<?php
	session_start();
	include_once('db_connection.php');

	if(isset($_POST['add'])){
		$patientName = $_POST['patientName'];
		$birthdate = $_POST['birthdate'];
		$age = $_POST['age'];
		$sex = $_POST['sex'];
		$religion = $_POST['religion'];
		$nationality = $_POST['nationality'];
		$status = $_POST['status'];
		$contactnumber = $_POST['contactnumber'];
		$address = $_POST['address'];
		$occupation = $_POST['occupation'];
		$dentalinsurance = $_POST['dentalinsurance'];

		$sql = "INSERT INTO patient (patientName , birthdate, age, sex, religion, nationality, status, contactnumber, address, occupation, dentalinsurance) VALUES ('$patientName', '$birthdate', '$age', '$sex', '$religion', '$nationality', '$status', '$contactnumber', '$address', '$occupation', '$dentalinsurance')";

		//use for MySQLi OOP
		if($conn->query($sql)){
			$_SESSION['success'] = 'Patient record added successfully';
		}
		///////////////

		//use for MySQLi Procedural
		// if(mysqli_query($conn, $sql)){
		// 	$_SESSION['success'] = 'Member added successfully';
		// }
		//////////////
		
		else{
			$_SESSION['error'] = 'Something went wrong while adding Patient record';
		}
	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: patient.php');
?>