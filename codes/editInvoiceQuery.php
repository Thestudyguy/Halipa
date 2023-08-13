<?php
	session_start();
	include_once('db_connection.php');

	if(isset($_POST['edit'])){
		$invoiceNumber = $_POST['invoiceNumber'];
		$patientName = $_POST['patientName'];
		$date = $_POST['date'];
		$dueDate = $_POST['dueDate'];
		$service = $_POST['service'];

		$sql = "UPDATE invoice SET InvoiceNumber='$invoiceNumber', InvoiceDate='$date', InvoiceDueDate='$dueDate', PatientName='$patientName', Service='$service' WHERE InvoiceNumber = '$invoiceNumber'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Invoice record updated successfully';
		}
		else{
			$_SESSION['error'] = 'Something went wrong in updating Invoice record';
		}
	}
	else{
		$_SESSION['error'] = 'Select Invoice to edit first';
	}

	header('location: invoice.php');

?>