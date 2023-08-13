<?php
	session_start();
	include_once('db_connection.php');

	if(isset($_GET['id'])){
		$sql = "DELETE FROM services WHERE id = '".$_GET['id']."'";

		//use for MySQLi OOP
		if($conn->query($sql)){
			$_SESSION['success'] = 'Service deleted successfully';
		}
		////////////////

		//use for MySQLi Procedural
		// if(mysqli_query($conn, $sql)){
		// 	$_SESSION['success'] = 'Member deleted successfully';
		// }
		/////////////////
		
		else{
			$_SESSION['error'] = 'Something went wrong in deleting Service';
		}
	}
	else{
		$_SESSION['error'] = 'Select Service to delete first';
	}

	header('location: services.php');
?>