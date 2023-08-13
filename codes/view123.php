<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  } else{

 if(isset($_POST['submit']))
  { 
    $eid=$_GET['editid'];
    $aptid=$_GET['aptid'];
    $status=$_POST['status'];
   $remark=$_POST['remark'];
      $sql= "update tblappointment set Status=:status,Remark=:remark where ID=:eid";
    $query=$dbh->prepare($sql);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':remark',$remark,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
 $query->execute();
 echo '<script>alert("Remark and status has been updated")</script>';
 echo "<script>window.location.href ='all-appointment.php'</script>";
}
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
						<h4 class="widget-title" style="color: blue">PATIENT RECORD</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					<div class="widget-body">
						<div class="table-responsive">
		

							<table border="1" class="table table-bordered mg-b-0">
              <?php
$eid = $_GET['viewID'];
$sql = "SELECT * FROM patient WHERE PatientId=:eid";
$query = $dbh->prepare($sql);
$query->bindParam(':eid', $eid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $row) {
?>
            <form id="medicineForm" action="process_patient.php" method="post" onsubmit="return validateForm()">

        <table class="table table-bordered">
        <tr>
            <th>Patient Name: <?php echo $row->patientName; ?></th>
            <input type="hidden" name="patientName" value="<?php echo $row->patientName; ?>">
            <th rowspan="2">Patient id: <?php echo $row->Patientid; ?></th>
        </tr>
        <!-- No input field for patientName as it's displayed directly in the table header -->
      
            <tr>
                <th>Birthdate : <?php echo $row->birthdate; ?></th>
            </tr>
            <tr>
                <th>Age : <?php echo $row->age; ?></th>
                <th>Sex: <?php echo $row->sex; ?></th>
            </tr>
            <tr>
                <th>Religion : <?php echo $row->religion; ?></th>
                <th>Nationality: <?php echo $row->nationality; ?></th>
            </tr>
            <tr>
                <th>Status : <?php echo $row->status; ?> </th>
                <th>Mobile Number: <?php echo $row->contactnumber; ?></th>
            </tr>
            <tr>
                <th>Address : <?php echo $row->address; ?></th>
                <th rowspan="2">Occupation: <?php echo $row->occupation; ?> </th>
            </tr>
            <tr>
                <th>Dental Insurance: <?php echo $row->dentalinsurance; ?></th>
            </tr>
            <tr></tr>
            <tr>
      <input type="hidden" name="patient_id" id="" value="<?php echo $row->Patientid; ?>">
                <th style="display: grid; grid-template-columns: auto auto auto;">
                    Tools: <br>
                    <?php
$sql = "SELECT * FROM add_medicine";
$stmt = $dbh->query($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while ($tool = $stmt->fetch()) {
    $expirationDate = strtotime($tool['expirationdate']);
    $quantity = $tool['quantity'];
    $currentDate = time();
    if ($expirationDate < $currentDate) {
        if ($quantity <= 0) {
            echo "<script>alert('Quantity selected exceeds the total quantity of the material or the material is expired');</script>";
        }
        continue;
    }

    // Skip displaying tools with zero quantity
    if ($quantity <= 0) {
        continue;
    }
?>

<div style="display: flex; gap: 5px; align-items: center; justify-content: start; margin-bottom: 5px;">
    <label>
        <input style="cursor: pointer;" type="checkbox" name="tools[]" value="<?php echo $tool['id']; ?>"><?php echo $tool['name']; ?>
    </label>
    <input style="width: 50px;" type="number" name="tool_quantity[<?php echo $tool['id']; ?>]" class="quantity" value="0" min="0" max="<?php echo $quantity; ?>">
</div>

<?php
}
?>
</th>
<th>Services: <br>
    <?php
    $sql = "SELECT * FROM services";
    $stmt = $dbh->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while ($service = $stmt->fetch()) {
    ?>
        <label>
  <input style="cursor: pointer;" type="radio" name="services[]" value="<?php echo $service['id']; ?>">
  <?php echo $service['servicename']; ?>
</label>
        <br>
    <?php } ?>
                </th>
            </tr>
        </table>
    <?php }
} ?>
<script>
function setQuantityOnCheckboxChange() {
  const toolCheckboxes = document.querySelectorAll('input[name="tools[]"]');

  toolCheckboxes.forEach((checkbox) => {
    const toolId = checkbox.value;
    const quantityInput = document.querySelector(`input[name="tool_quantity[${toolId}]"]`);

    checkbox.addEventListener('change', function() {
      if (this.checked) {
        quantityInput.value = 1;
      } else {
        quantityInput.value = 0;
      }
    });
  });
}
function validateForm() {
  const toolCheckboxes = document.querySelectorAll('input[name="tools[]"]');
  let isToolChecked = false;

  toolCheckboxes.forEach((checkbox) => {
    const toolId = checkbox.value;
    const quantityInput = document.querySelector(`input[name="tool_quantity[${toolId}]"]`);

    if (checkbox.checked && parseInt(quantityInput.value) > 0) {
      isToolChecked = true;
    }
  });

  const serviceCheckboxes = document.querySelectorAll('input[name="services[]"]');
  let isServiceChecked = false;

  serviceCheckboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      isServiceChecked = true;
    }
  });

  if (!isToolChecked && !isServiceChecked) {
    alert("Please select at least one tool and one service.");
    return false;
  } else if (!isToolChecked) {
    alert("Please select at least one tool with a quantity greater than 0.");
    return false;
  } else if (!isServiceChecked) {
    alert("Please select at least one service.");
    return false;
  }

  return true;
}
document.addEventListener('DOMContentLoaded', setQuantityOnCheckboxChange);
</script>
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
 <button type="submit" id="submitButton" name="submit" class="btn btn-primary">Submit</button>
  
  </form>  

  

</table>
</div>

</div>

                      
                        </div>
                    </div>

						</div>

					</div><!-- .widget-body -->
					
   
				</div><!-- .widget -->
			</div><!-- END column -->
			
			
		</div><!-- .row -->
	</section><!-- .app-content -->
</div><!-- .wrap -->
  <!-- APP FOOTER -->

  <!-- /#app-footer -->
</main>
<!--========== END app main -->

	<!-- APP CUSTOMIZER -->


	
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