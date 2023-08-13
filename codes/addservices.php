<?php
	session_start();
	include_once('db_connection.php');

	if(isset($_POST['submit'])){
		$servicename = $_POST['servicename'];
		$description = $_POST['description'];
		$price = $_POST['price'];
		
		

		$sql = "INSERT INTO `services`(`id`, `servicename`, `description`,`price`) VALUES (NULL,'$servicename','$description','$price')";

		//use for MySQLi OOP
		if($conn->query($sql)){
			$_SESSION['success'] = 'Service added successfully';
		}
		///////////////

		//use for MySQLi Procedural
		// if(mysqli_query($conn, $sql)){
		// 	$_SESSION['success'] = 'Member added successfully';
		// }
		//////////////
		
		else{
			$_SESSION['error'] = 'Something went wrong while adding Service';
		}
	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: services.php');
?>