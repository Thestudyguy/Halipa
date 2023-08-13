<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  } else{

	//if (isset($_POST['markPaid']) && isset($_POST['invoiceNumber'])) {
	//	// Update the status to "Paid" in the database based on $_POST['invoiceNumber']
	//
	//	$invoiceNumber = $_POST['invoiceNumber'];
	//	$updateSql = "UPDATE invoice SET Status = 'Paid' WHERE InvoiceNumber = :invoiceNumber";
	//	$updateQuery = $dbh->prepare($updateSql);
	//	$updateQuery->bindParam(':invoiceNumber', $invoiceNumber, PDO::PARAM_INT);
	//	if ($updateQuery->execute()) {
	//		// Get the patient name and service from the invoice table
	//		$selectSql = "SELECT PatientName, Service FROM invoice WHERE InvoiceNumber = :invoiceNumber";
	//		$selectQuery = $dbh->prepare($selectSql);
	//		$selectQuery->bindParam(':invoiceNumber', $invoiceNumber, PDO::PARAM_INT);
	//		if ($selectQuery->execute() && $selectQuery->rowCount() > 0) {
	//			$invoiceData = $selectQuery->fetch(PDO::FETCH_ASSOC);
	//			$patientName = $invoiceData['PatientName'];
	//			$service = $invoiceData['Service'];
	//
	//			// Insert the data into the sales_report table with the current date
	//			$insertSql = "INSERT INTO sales_report (ID, Date, Name, Service) 
	//						  VALUES (:invoiceNumber, :currentDate, :patientName, :service)";
	//			$insertQuery = $dbh->prepare($insertSql);
	//			$insertQuery->bindParam(':invoiceNumber', $invoiceNumber, PDO::PARAM_INT);
	//			$insertQuery->bindValue(':currentDate', date('Y-m-d'), PDO::PARAM_STR);
	//			$insertQuery->bindParam(':patientName', $patientName, PDO::PARAM_STR);
	//			$insertQuery->bindParam(':service', $service, PDO::PARAM_STR);
	//
	//			if ($insertQuery->execute()) {
	//				// Redirect back to the invoice page after updating the status and inserting into sales_report
	//				header('Location: invoice.php');
	//				exit();
	//			} else {
	//				// Handle the error (e.g., show an error message)
	//				echo "Failed to insert data into sales_report table.";
	//			}
	//		} else {
	//			echo "Invoice data not found.";
	//		}
	//	} else {
	//		echo "Failed to update status.";
	//	}
	//}
	
	

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>Invoice</title>
	
	<link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
	<!-- build:css assets/css/app.min.css -->
	<link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="libs/bower/fullcalendar/dist/fullcalendar.min.css">
	<link rel="stylesheet" href="libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/core.css">
	<link rel="stylesheet" href="assets/css/app.css">
	<!-- endbuild -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
	<script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>


	

	<script>
		Breakpoints();
	</script>
	<style>
		.height10{
			height:10px;
		}
    
		.mtop10{
			margin-top:10px;
		}
		.modal-label{
			position:relative;
			top:7px
		}
	</style>
</head>
	
<body class="menubar-left menubar-unfold menubar-light theme-primary">
<!--============= start main area -->



<?php include_once('includes/header.php');?>

<?php include_once('includes/sidebar.php');?>



<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="wrap">
	<section class="app-content">
		<div class="row">
			<!-- DOM dataTable -->
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">INVOICE</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					<div class="widget-body">
						<div class="table-responsive">
							<table id="myTable" class="table table-bordered table-hover js-basic-example dataTable table-custom">
							<?php
				if(isset($_SESSION['error'])){
					echo
					"
					<div class='alert alert-danger text-center'>
						<button class='close'>&times;</button>
						".$_SESSION['error']."
					</div>
					";
					unset($_SESSION['error']);
				}
				if(isset($_SESSION['success'])){
					echo
					"
					<div class='alert alert-success text-center'>
						<button class='close'>&times;</button>
						".$_SESSION['success']."
					</div>
					";
					unset($_SESSION['success']);
				}
			?>
			<div class="row1 ">
			<!-- <a href="createnewinvoice.php" class="btn btn-primary"> <span class="glyphicon glyphicon-plus"> </span> Create new Invoice</a> -->
			</div>
			<div class="height10">
			</div>
			<div class="row1">
				
			<thead>
						<th>No</th>
						<th>Invoice Number</th>
						<th>Patient</th>
						<th>Date</th>
						<!-- <th>Due Date</th> -->
						<th>Service</th>
						<th>Price</th>
						<th>Print</th>
                        <th>Action</th>
						
					</thead>
					<tbody>
					<?php
$sql = "SELECT i.InvoiceNumber, i.InvoiceDate, i.InvoiceDueDate, i.PatientName, i.Status, s.Specialization, srv.Price
FROM invoice i
INNER JOIN tblspecialization s ON i.Service = s.ID
INNER JOIN services srv ON i.Service = srv.ID;";

$query = $dbh->prepare($sql);
$query->execute();

$cnt = 1;
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlentities($cnt++) . "</td>";
    echo "<td>" . htmlentities($row['InvoiceNumber']) . "</td>";
    echo "<td>" . htmlentities($row['PatientName']) . "</td>";
    echo "<td>" . htmlentities($row['InvoiceDate']) . "</td>";
    echo "<td>" . htmlentities($row['Specialization']) . "</td>";
    echo "<td>" . htmlentities($row['Price']) . "</td>";
            echo "<td>
			<form method='post' action='invoicePDF.php' target='_blank'>
			<input type='hidden' name='data' value='" . htmlentities(json_encode($row)) . "'>
			<button type='submit' class='btn btn-primary status-btn'>Generate PDF</button>
		</form>
                  </td>";
            echo "<td>
                    <button class='btn btn-success' data-toggle='modal' data-target='#edit_" . $row['InvoiceNumber'] . "' href='#edit_" . $row['InvoiceNumber'] . "'><span class='glyphicon glyphicon-edit'></span>Edit</button>
                    <button data-toggle='modal' data-target='#delete_" . $row['InvoiceNumber'] . "' href='#delete_" . $row['InvoiceNumber'] . "' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span>Delete</button>
                  </td>";
            echo "</tr>";
            include("deleteInvoiceModal.php");
            include("editInvoice.php");
        }
        ?>


					</tbody>
				
							</table>
						</div>
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div><!-- END column -->
			
			
		</div><!-- .row -->
	</section><!-- .app-content -->
</div><!-- .wrap -->
  <!-- APP FOOTER -->
  <?php include_once('includes/footer.php');?>
  <!-- /#app-footer -->
</main>
<?php include('add_modal_patient.php') ?>

<!--========== END app main -->

	<!-- APP CUSTOMIZER -->
<?php include_once('includes/customizer.php');?>

	
		<!-- build:js assets/js/core.min.js -->
	<script src="libs/bower/jquery/dist/jquery.js"></script>
	<script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>
	<script src="libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
	<script src="libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
	<script src="libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
	<script src="libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
	<script src="libs/bower/PACE/pace.min.js"></script>
	<!-- endbuild -->

	<!-- build:js assets/js/app.min.js -->
	<script src="assets/js/library.js"></script>
	<script src="assets/js/plugins.js"></script>
	<script src="assets/js/app.js"></script>
	<!-- endbuild -->
	<script src="libs/bower/moment/moment.js"></script>
	<script src="libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
	<script src="assets/js/fullcalendar.js"></script>

	<link rel="stylesheet" type="text/css" href="datatable/dataTable.bootstrap.min.css">
	<script src="jquery/jquery.min.js"></script>
	
	<script src="datatable/jquery.dataTables.min.js"></script>
	<script src="datatable/dataTable.bootstrap.min.js"></script>
	<script>
$(document).ready(function(){
	
    $('#myTable').DataTable();

    
    $(document).on('click', '.close', function(){
    	$('.alert').hide();
    })
});

/**
 * function handleHover(event) {
        const button = event.target;
        if (button.textContent === "Pending") {
            button.textContent = "Paid";
        }
    }

    // Function to change the button text back to "Pending" on mouseleave
    function handleMouseLeave(event) {
        const button = event.target;
        if (button.textContent === "Paid") {
            button.textContent = "Pending";
        }
    }

    // Add event listeners to buttons with class 'status-btn' for hover effect
    const statusButtons = document.querySelectorAll('.status-btn');
    statusButtons.forEach(function (button) {
        button.addEventListener('mouseenter', handleHover);
        button.addEventListener('mouseleave', handleMouseLeave);
    });
 * 
 */

</script>

</body>
</html>
<?php }  ?>