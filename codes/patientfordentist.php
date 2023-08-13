<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  } else{



  ?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>Patient Record</title>
	
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
						<h4 class="widget-title">PATIENT RECORD</h4>
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
			<div class="row">
			<a href="view.php" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> View</a>
			</div>
			<div class="height10">
			</div>
			<div class="row1">
				
					<thead>
						<th>No</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Middlename</th>
						<th>Birthdate</th>
						<th>Age</th>
						<th>Sex</th>
						<th>Religion</th>
						<th>Nationality</th>
						<th>Status</th>
						<th>Mobile Number</th>
						<th>Address</th>
						<th>Occupation</th>
						<th>Dental Insurance</th>
						
						<th>Action</th>
					</thead>
					<tbody>
						<?php
							include_once('db_connection.php');
							$sql = "SELECT * FROM patient";

							
							$query = $conn->query($sql);
							while($row = $query->fetch_assoc()){
								echo 
								"<tr>
									<td>".$row['Patientid']."</td>
									<td>".$row['firstname']."</td>
									<td>".$row['lastname']."</td>
									<td>".$row['middlename']."</td>
									<td>".$row['birthdate']."</td>
									<td>".$row['age']."</td>
									<td>".$row['sex']."</td>
									<td>".$row['religion']."</td>
									<td>".$row['nationality']."</td>
									<td>".$row['status']."</td>
									<td>".$row['contactnumber']."</td>
									<td>".$row['address']."</td>
									<td>".$row['occupation']."</td>
									<td>".$row['dentalinsurance']."</td>
								

									<td>
										<a href='viewappointmentlist.php".$row['Patientid']."'><span class='btn btn-primary glyphicon glyphicon-search'>View</span></a>
										
									</td>
								</tr>";
								include('edit_delete_modal_patient.php');
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
</script>

</body>
</html>
<?php }  ?>