<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  } else{
	$eid = $_SESSION['damsid'];

	$sql = "SELECT FullName, Email, Access FROM tbldoctor WHERE ID=:eid";
	$query = $dbh->prepare($sql);
	$query->bindParam(':eid', $eid, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	
	$isAdminUser = false; // Initialize as false by default
	
	foreach ($results as $row) {
	  $email = $row->Email;
	  $fname = $row->FullName;
	  $access = $row->Access; // Assuming 'Access' field in tbldoctor holds the access level
	  
	  if ($access === 'Admin Access') {
		$isAdminUser = true; // Set to true if the user has admin access
		break; // No need to continue the loop if we found admin access
	  }
	}
	


  ?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>Inventory</title>
	
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

	<link rel="stylesheet" type="text/css" href="datatable/dataTable.bootstrap.min.css">
	

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
						<h4 class="widget-title">INVENTORY MARTERIAL</h4>
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
			<?php if ($isAdminUser) : ?>
					<a href="#addnew" data-toggle="modal" class="btn btn-primary"><span></span> New</a>
					<a href="history.php" class="btn btn-primary"><span class=""></span>Material Logs</a>
        				<?php endif; ?>
				
				
			</div>
			<div class="height10">
			</div>
			<div class="row1">
				
			<thead>
						<th>No</th>
						<th>Material</th>
						<th>Quantity</th>
						<th>Purchase date</th>
						<th>Expiration date</th>
						<th>Status</th>
                        <?php if ($isAdminUser) : ?>
						<th>Edit</th>
						<th>Delete</th>
						<th>Expired</th>
        				<?php endif; ?>
						
						
					</thead>
							
                    <tbody>
					<?php
include_once('db_connection.php');



$sql = "SELECT * FROM add_medicine";
$query = $conn->query($sql);

while ($row = $query->fetch_assoc()) {
    $expirationDate = strtotime($row['expirationdate']);
    $currentDate = time();
    $isExpired = $expirationDate < $currentDate;
    $isZeroQuantity = $row['quantity'] <= 0;
    
    // Determine the status based on quantity and expiration
    if ($isExpired) {
        $status = "Expired";
    } elseif ($isZeroQuantity) {
        $status = "Out of Stock";
    } else {
        $status = "In Stock";
    }

    $expirationClass = $isExpired ? "blinking-red" : "";
    $quantityClass = $isZeroQuantity ? "zero-quantity" : "";

    echo "<tr>
        <td class='{$expirationClass} {$quantityClass}'>" . $row['id'] . "</td>
        <td class='{$expirationClass} {$quantityClass}'>" . $row['name'] . "</td>
        <td class='{$expirationClass} {$quantityClass}'>" . $row['quantity'] . "</td>
        <td class='{$expirationClass} {$quantityClass}'>" . $row['purchasedate'] . "</td>
        <td class='{$expirationClass} {$quantityClass}'>" . $row['expirationdate'] . "</td>
        <td class='{$expirationClass} {$quantityClass}'>" . $status . "</td>";
        
    if ($isAdminUser) {
        echo "<td>
            <center><a href='#edit_" . $row['id'] . "' class='btn btn-success btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-edit'></span> Edit</a></center>
			<td> <center> <a href='#delete_" . $row['id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a></center>
			<td> <center><a href='#mark_as_expired_" . $row['id'] . "' class='btn btn-info btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-exclamation-sign'></span> Expired</a></center>
        </td>";
    }
    echo "</tr>";
/*
<td>
 <a href='#edit_" . $row['id'] . "' class='btn btn-success btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-edit'></span> Edit</a>
            <a href='#delete_" . $row['id'] . "'' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a>
			<a href='#mark_as_expired_" . $row['id'] . "'' class='btn btn-info btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Mark as Expired</a>
*/
    // Modal for Delete
    echo "<div class='modal fade' id='delete_" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <center><h4 class='modal-title' id='myModalLabel'>Delete Material Record</h4></center>
                </div>
                <div class='modal-body'>	
                    <p class='text-center'>Are you sure you want to Delete</p>
                    <h2 class='text-center'>" . $row['name'] . "</h2>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span> Cancel</button>
                    <a href='deletematerial.php?action=delete&id=" . $row['id'] . "' class='btn btn-danger'>
                        <span class='glyphicon glyphicon-trash'></span> Yes
                    </a>
                </div>
            </div>
        </div>
    </div>";

    // Modal for Mark as Expired
    echo "<div class='modal fade' id='mark_as_expired_" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <center><h4 class='modal-title' id='myModalLabel'>Mark Material as Expired</h4></center>
                </div>
                <div class='modal-body'>	
                    <p class='text-center'>Mark Material as Expired <br class='text-dark'>Material will also be deleted </p>
                    <h2 class='text-center'>" . $row['name'] . "</h2>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span> Cancel</button>
                    <a href='deletematerial.php?action=mark_expired&id=" . $row['id'] . "' class='btn btn-danger'>
                        <span class='glyphicon glyphicon-trash'></span> Yes
                    </a>
                </div>
            </div>
        </div>
    </div>";
include("edit_delete_modal_material.php");

}


?>

					</tbody>
                  <style>
					 .zero-quantity {
        			color: black;
        			font-weight: 600;
					font-size: ;
    }
					.blinking-red {
					font-size: ;
					font-weight: 600;
					color: red;
					animation: blink .5s infinite;
}	


				  </style>
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
<?php include('add_modal_material.php') ?>
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
	<script src="libs/bower/moment/moment.js"></script>
	<script src="libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
	<script src="assets/js/fullcalendar.js"></script>

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