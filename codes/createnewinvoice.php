<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (isset($_POST['addinvoice'])) {
    $invoiceNumber = mt_rand(100000000, 999999999);
    $invoiceDate = $_POST['DateInvoiced'];
    $dueDate = $_POST['DueDate'];
    $patientName = $_POST['patient_name'];
    $service = $_POST['specialization'];
    
    // Add the default status value
    $status = 'Pending';

    $sql = "INSERT INTO invoice (InvoiceNumber, InvoiceDate, InvoiceDueDate, PatientName, Service, status) 
            VALUES (:invoiceNumber, :invoiceDate, :dueDate, :patientName, :service, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':invoiceNumber', $invoiceNumber, PDO::PARAM_INT);
    $query->bindParam(':invoiceDate', $invoiceDate, PDO::PARAM_STR);
    $query->bindParam(':dueDate', $dueDate, PDO::PARAM_STR);
    $query->bindParam(':patientName', $patientName, PDO::PARAM_STR);
    $query->bindParam(':service', $service, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);

    if ($query->execute()) {
        $_SESSION['success'] = 'Invoice created successfully';
    } else {
        $_SESSION['error'] = 'Something went wrong while creating the invoice';
    }

    header('location: invoice.php');
    exit();
}

if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  } else{



  ?>
  
<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>Create New Invoice</title>
	
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

	

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
						<h4 class="widget-title">CREATE NEW INVOICE</h4>
					</header><!-- .widget-header -->
					
					<hr class="widget-separator">
					
					<div class="widget-body">
					
						<div class="table-responsive">
							
							<table id="myTable" class="table table-bordered table-hover js-basic-example dataTable table-custom">
							<div class="col-md-6">

		<div class="col-md-12">
			
		<form role="form" action="" method="POST">
			<br>
			<label>Invoice Date: </label> 
			<div> 
				 <div class="input-group date  " data-provide="datepicker" data-date="2012-12-21T15:25:00Z">
				   <input type="date" class="form-control input-sm date_picker date_inv" id="DateInvoiced" name="DateInvoiced" placeholder="mm/dd/yyyy"   autocomplete="off" required value="" /> 
				   <span class="input-group-addon"><i class="fa fa-th"></i></span>
			   </div>
			</div>
			<br>
			<label>Due Date: </label> 
	 		<div> 
		 		 <div class="input-group date" data-provide="datepicker" data-date="2012-12-21T15:25:00Z">
					<input type="date" class="form-control input-sm date_picker date_inv" id="DueDate" name="DueDate" placeholder="mm/dd/yyyy"   autocomplete="off" required value="" /> 
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
			</div>
			<br>
			<div class="autocomplete search">
			 <label>Patient Name: </label>
			 <input type="text" name="patient_name" id="searchPatient_name" class="form-control" autocomplete="off">
		 <style>
			.suggestion{
				width: 200px;
				padding: 10px 15px;
				display: none;
			}
			li{
				list-style: none;
				cursor: pointer;
				transition: .1s ease-in-out;
			}
			li:hover{
				background-color: whitesmoke;
			}
		 </style> 	
		  <div class="suggestion">
  <ul id="dropdown">
  </ul>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $("#searchPatient_name").keyup(function() {
      var term = $(this).val();

      $.ajax({
        url: 'data.php',
        method: 'POST',
        data: { searchPatient_name: term },
        success: function(response) {
          $("#dropdown").html(response);
        }
      });

      if (term !== '') {
        $(".suggestion").show();
      } else {
        $(".suggestion").hide();
      }
    });

    $(document).on('click', '#dropdown li', function() {
      var selectedPatient = $(this).text();
      $("#searchPatient_name").val(selectedPatient);
      $(".suggestion").hide();
    });
  });
</script>

 	 		</div>  
			<br>
			<div class="autocomplete search">
 	 	 <label>Service: </label>
 	 	 <select  name="specialization" id="specialization" class="form-control" required>
<option value="" hidden selected>Select Service</option>
<!--- Fetching States--->
<?php
$sql="SELECT * FROM tblspecialization";
$stmt=$dbh->query($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while($row =$stmt->fetch()) { 
  ?>
<option value="<?php echo $row['ID'];?>"><?php echo $row['Specialization'];?></option>
<?php }?>
</select>
		  <br>
		  <button class="btn btn btn-primary" type="submit" name="addinvoice">Create Invoice</button>

			<a href="invoice.php" class="btn btn-success">Back</a>
		</form>
		<button class="btn btn btn-primary" data-toggle='modal' data-target='#patients' href="#patients">View Patients</button>
 	 		</div> 

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
  <?php include_once('addinvoice.php');?>
<?php include("viewPatients.php") ?>

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
</body>
</html>
<?php }  ?>