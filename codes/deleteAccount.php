<?php
	session_start();
	include_once('db_connection.php');
	
	if(isset($_GET['accountid'])){	
		$doctorID = $_GET['accountid'];
		$sql = "DELETE FROM tbldoctor WHERE ID = '".$doctorID."'";

		if($conn->query($sql)){
			$_SESSION['success'] = 'Account deleted successfully';
		}
		else{
			$_SESSION['error'] = 'Something went wrong in deleting Account';
		}
	}
	else{
		$_SESSION['error'] = 'Select Account to delete first';
	}

	header('location: accounts.php');
?>