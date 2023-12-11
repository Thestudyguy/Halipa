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
	
	<title>All Appointment</title>
	
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
						<h4 class="widget-title">ALL APPOINTMENT</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					<div class="widget-body">
						<div class="table-responsive">
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
							<table id="myTable" class="table table-bordered table-hover js-basic-example dataTable table-custom">
								
							<thead>
									<tr>
										<th>No</th>
										<th>Appointment Number</th>
										<th>Patient Name</th>
										<th>Mobile Number</th>
										<th>Email</th>
										<th>Date</th>
										<th>Time</th>
										<th>Service</th>
									<th>Status</th>
										<th>View</th>
										<th>Delete</th>
									</tr>
								</thead>
							
								<tbody>
								<?php
$docid = $_SESSION['damsid'];
$sql = "SELECT a.*, s.Specialization
        FROM tblappointment a
        LEFT JOIN tblspecialization s ON a.Specialization = s.ID";
$query = $dbh->prepare($sql);
$query->execute();

$cnt = 1;
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $status = $row['Status'];
    $statusColor = '';
    if ($status === "Approved") {
        $statusColor = "blue";
    } elseif ($status === "Decline") {
        $statusColor = "red";
    } elseif ($status === "Pending") {
        $statusColor = "yellow";
    } else {
        // Default text color if status is not recognized
        $statusColor = "black";
        $status = "Pending"; // Display "Pending" for unrecognized status
    }
    ?>
    <tr>
        <td><?php echo $cnt; ?></td>
        <td><?php echo $row['AppointmentNumber']; ?></td>
        <td><?php echo $row['Name']; ?></td>
        <td><?php echo $row['MobileNumber']; ?></td>
        <td><?php echo $row['Email']; ?></td>
        <td><?php echo $row['AppointmentDate']; ?></td>
        <td><?php echo date('h:i A', strtotime($row['AppointmentTime'])); ?></td>
        <td><?php echo $row['Specialization']; ?></td>

        <td style="color: <?php echo $statusColor; ?>">
            <?php echo $status; ?>
        </td>

        <td>
           	<center><a href="view-appointment-detail.php?editid=<?php echo $row['ID']; ?>&aptid=<?php echo $row['AppointmentNumber']; ?>" class="btn btn-primary btn-sm" ><span class='glyphicon glyphicon-search'></span> View</a>
		<td>    
			<center><a href="#modal-<?php echo $row['AppointmentNumber']; ?>" name="AppointmentNumber" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-<?php echo $row['AppointmentNumber']; ?>">
                <span class='glyphicon glyphicon-trash'></span> Delete
            </a>
            <?php include('deleteappointment.php'); ?>
        </td>
    </tr>
    <?php
    $cnt++;
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