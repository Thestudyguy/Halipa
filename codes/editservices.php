<?php
	session_start();
	include_once('db_connection.php');

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$servicename = $_POST['servicename'];
		$description = $_POST['description'];
		$price = $_POST['price'];
		

		$sql = "UPDATE services SET servicename = '$servicename', description = '$description', price = '$price' WHERE id = '$id'";

		//use for MySQLi OOP
		if($conn->query($sql)){
			$_SESSION['success'] = 'Services updated successfully';
		}
		///////////////

		//use for MySQLi Procedural
		// if(mysqli_query($conn, $sql)){
		// 	$_SESSION['success'] = 'Member updated successfully';
		// }
		///////////////
		
		else{
			$_SESSION['error'] = 'Something went wrong in updating Services';
		}
	}
	else{
		$_SESSION['error'] = 'Select service to edit first';
	}

	header('location: services.php');

?>