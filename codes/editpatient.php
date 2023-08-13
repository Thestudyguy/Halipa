<?php
	session_start();
	include_once('db_connection.php');

	if(isset($_POST['edit'])){
		$Patientid = $_POST['Patientid'];
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

		$sql = "UPDATE patient SET patientName='$patientName', birthdate='$birthdate', age='$age', sex='$sex', religion='$religion', nationality='$nationality', status='$status', contactnumber='$contactnumber', address='$address', occupation='$occupation', dentalinsurance='$dentalinsurance' WHERE Patientid = '$Patientid'";


		//use for MySQLi OOP
		if($conn->query($sql)){
			$_SESSION['success'] = 'Patient record updated successfully';
		}
		///////////////

		//use for MySQLi Procedural
		// if(mysqli_query($conn, $sql)){
		// 	$_SESSION['success'] = 'Member updated successfully';
		// }
		///////////////
		
		else{
			$_SESSION['error'] = 'Something went wrong in updating patient record';
		}
	}
	else{
		$_SESSION['error'] = 'Select member to edit first';
	}

	header('location: patient.php');

?>