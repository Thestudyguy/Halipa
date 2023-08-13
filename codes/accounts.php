<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  exit;
  } 
  
  else{



  ?>
  
<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>Accounts</title>

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
						<h4 class="widget-title">ACCOUNTS</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
      <span class="glyphicon glyphicon-plus"></span> New
    </button>
					<div class="widget-body">
					
					<!-- modal for new account -->
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">New Entry</h4>
        </div>
        <div class="modal-body">
          <!-- Input fields inside the modal -->
          <form method="POST" action="insertdoctor.php">
            <div class="form-group">
              <label for="fullName">Full Name:</label>
              <input type="text" class="form-control" id="fullName" name="fullname" required>
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
              <label for="access">Account Privilege:</label>
              <select class="form-control" name="access" required>
                <option value="" selected hidden>Select Account Privilege</option>
                <option value="Admin Access">Admin Access</option>
                <option value="View Only">View Only</option>
              </select>
            </div>
			<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button name="submit" class="btn btn-primary">Save</button>
    </div>
          </form>
        </div>
      
      </div>
    </div>
  </div>
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
										<th>Full Name</th>
										<th>Mobile Number</th>
										<th>Email</th>
										<th>Password</th>
										<th>Account Privilege</th>
										<th>Action</th>
										
									</tr>
								</thead>
							
								<tbody>
								<?php
$docid = $_SESSION['damsid'];
$sql = "SELECT * FROM tbldoctor";
$query = $dbh->prepare($sql);
$query->execute();

$cnt = 1;
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  $userID = $row['ID'];
  $loggedInUserID = $_SESSION['damsid'];

  //echo "User ID: " . $userID . " - Logged-in User ID: " . $loggedInUserID . "<br>";

  $isCurrentUser = ($userID == $loggedInUserID);
  ?>

  <tr>
      <td><?php echo $cnt++; ?></td>
      <td><?php echo $row['FullName']; ?></td>
      <td><?php echo $row['MobileNumber']; ?></td>
      <td><?php echo $row['Email']; ?></td>
      <td><?php echo $row['Password']; ?></td>
      <td><?php echo $row['Access']; ?></td>
      <td>
          <?php if ($isCurrentUser): ?>
              <span class="text-success"><strong>Currently Logged In</strong></span>
          <?php else: ?>
              <a href="#edit_<?php echo $userID; ?>" class="btn btn-success" data-toggle="modal">
                  <span class='glyphicon glyphicon-edit'></span> Edit
              </a>
              <a href="#delete_<?php echo $userID; ?>" class="btn btn-danger delete-btn" data-toggle="modal">
                  <span class='glyphicon glyphicon-trash'></span> Delete
              </a>
          <?php endif; ?>
      </td>
  </tr>
<?php
include('accountActions.php');
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