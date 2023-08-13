<?php
	session_start();
	include_once('db_connection.php');

	if(isset($_POST['submit'])){
		$name = $_POST['name'];
		$quantity = $_POST['quantity'];
		$purchasedate = $_POST['purchasedate'];
		$expirationdate = $_POST['expirationdate'];
		

		$sql = "INSERT INTO `add_medicine`(`id`, `name`, `quantity`,`purchasedate`,`expirationdate`) VALUES (NULL,'$name','$quantity','$purchasedate','$expirationdate')";

		//use for MySQLi OOP
		if($conn->query($sql)){
			$_SESSION['success'] = 'Material added successfully';
		}
		///////////////

		//use for MySQLi Procedural
		// if(mysqli_query($conn, $sql)){
		// 	$_SESSION['success'] = 'Member added successfully';
		// }
		//////////////
		
		else{
			$_SESSION['error'] = 'Something went wrong while adding Material';
		}
	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: inventory.php');
?>