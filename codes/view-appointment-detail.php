<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
require 'C:\xampp\htdocs\halipa\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\halipa\PHPMailer-master\src\SMTP.php';
require 'C:\xampp\htdocs\halipa\PHPMailer-master\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  } else{

    if (isset($_POST['submit'])) {
      $eid = $_GET['editid'];
      $aptid = $_GET['aptid'];
      $status = $_POST['status'];
      $remark = $_POST['remark'];
      $message = $_POST['message'];

      if ($status == 'Approved' || $status == 'Pending') {
          $sql = "SELECT COUNT(*) as count FROM tblappointment 
                  WHERE ID != :eid 
                  AND AppointmentDate = (SELECT AppointmentDate FROM tblappointment WHERE ID = :eid) 
                  AND AppointmentTime = (SELECT AppointmentTime FROM tblappointment WHERE ID = :eid) 
                  AND Specialization = (SELECT Specialization FROM tblappointment WHERE ID = :eid) 
                  AND (Status = 'Approved' OR Status = 'Pending')";
  
          $query = $dbh->prepare($sql);
          $query->bindParam(':eid', $eid, PDO::PARAM_STR);
          $query->execute();
          $result = $query->fetch(PDO::FETCH_ASSOC);
  
          if ($result['count'] >= 3) {
              echo '<script>alert("There are already three appointments with the same date, time, and specialization. Cannot approve this appointment.")</script>';
              echo "<script>window.location.href ='all-appointment.php'</script>";
              exit;
          }
      }
  
      $sql = "UPDATE tblappointment SET Status=:status, Remark=:remark WHERE ID=:eid";
      $query = $dbh->prepare($sql);
      $query->bindParam(':status', $status, PDO::PARAM_STR);
      $query->bindParam(':remark', $remark, PDO::PARAM_STR);
      $query->bindParam(':eid', $eid, PDO::PARAM_STR);
      $query->execute();
  
      if ($status !== 'Cancelled') {
          $eid = $_GET['editid'];
          $sql = "SELECT Name, MobileNumber, Email FROM tblappointment WHERE ID = :eid";
          $query = $dbh->prepare($sql);
          $query->bindParam(':eid', $eid, PDO::PARAM_STR);
          $query->execute();
  
          $row = $query->fetch(PDO::FETCH_OBJ);
  
          if ($row) {
            $patientName = $row->Name;
            $contactNumber = $row->MobileNumber;
            $email = $row->Email;
        
            if ($status !== 'Decline') {
              $insertSql = "INSERT INTO patient (patientName, contactNumber) VALUES (:patientName, :contactNumber)";
              $insertQuery = $dbh->prepare($insertSql);
              $insertQuery->bindParam(':patientName', $patientName, PDO::PARAM_STR);
              $insertQuery->bindParam(':contactNumber', $contactNumber, PDO::PARAM_STR);
              $insertQuery->execute();
          }
        
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'lagrosaedrian06@gmail.com';
            $mail->Password = 'n b i c v n x x m k m i e a q h'; // auto-generated password for email if mag ilis ug email need i configure ang gamiton na email
            $mail->SMTPSecure = 'tls';
        
            // Email content
            $mail->setFrom('lagrosaedrian06@gmail.com', 'Halipa Dental Clinic Website');
            $mail->addAddress($email, $patientName);
            $mail->Subject = 'Appointment Status Update';
            $mail->Body = 'Dear ' . $patientName . ', your appointment has been ' . $status . '.' . "\n\n" . $message;
        
            try {
                $mail->send();
                echo '<script>alert("Remark and status have been updated. Email notification sent to the recipient.")</script>';
            } catch (Exception $e) {
                echo '<script>alert("Remark and status have been updated, but there was an error sending the email: ' . $mail->ErrorInfo . '")</script>';
            }
        }
      }
  
      echo "<script>window.location.href ='all-appointment.php'</script>";
  }
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>View Appointment Detail</title>
	
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
						<h4 class="widget-title" style="color: blue">APPOINTMENT DETAILS</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					<div class="widget-body">
						<div class="table-responsive">
							<?php
                  $eid=$_GET['editid'];
$sql="SELECT * from tblappointment  where ID=:eid";
$query = $dbh -> prepare($sql);
$query-> bindParam(':eid', $eid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
							<table border="1" class="table table-bordered mg-b-0">
                                            <tr>
    <th>Appointment Number</th>
    <td><?php  echo $aptno=($row->AppointmentNumber);?></td>
    <th>Patient Name</th>
    <td><?php  echo $row->Name;?></td>
  </tr>
  
  <tr>
    <th>Mobile Number</th>
    <td><?php  echo $row->MobileNumber;?></td>
    <th>Email</th>
    <td><?php  echo $row->Email;?></td>
  </tr>
   <tr>
    <th>Appointment Date</th>
    <td><?php  echo $row->AppointmentDate;?></td>
    <th>Appointment Time</th>
    <td><?php echo htmlentities(date('h:i A', strtotime($row->AppointmentTime)));?></td>
  </tr>
   
  <tr>
    <th>Apply Date</th>
    <td><?php  echo $row->ApplyDate;?></td>
     <th>Appointment Final Status</th>

    <td colspan="4"> <?php  $status=$row->Status;
    
if($row->Status=="")
{
  echo "Not yet updated";
}

if($row->Status=="Approved")
{
 echo "Your appointment has been approved";
}


if($row->Status=="Cancelled")
{
  echo "Your appointment has been cancelled";
}



     ;?></td>
  </tr>
   <tr>
    
<th >Remark</th>
 <?php if($row->Remark==""){ ?>

                     <td colspan="3"><?php echo "Not Updated Yet"; ?></td>
<?php } else { ?>                  <td colspan="3"> <?php  echo htmlentities($row->Remark);?>
                  </td>
                  <?php } ?>
   
  </tr>
 
<?php $cnt=$cnt+1;}} ?>

</table> 
<br>

 
<?php 

if ($status=="" ){
?> 
<p align="center"  style="padding-top: 20px">                            
 <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal" data-target="#myModal">Take Action</button></p>  

<?php } ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
     <div class="modal-content">
      <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Take Action</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <table class="table table-bordered table-hover data-tables">

                                 <form method="post" name="submit">

                                
                               
     <tr>
    <th>Remark :</th>
    <td>
    <select name="remark" placeholder="Remark" rows="12" cols="14" class="form-control wd-450" required="true">
      <option value="" hidden >Select Remark</option>
      <option value="Approved Appointment">Approved Appointment</option>
      <option value="Decline Appointment">Decline Appointment</option>
    </select></td>
  </tr> 
   
  <tr>
    <th>Status :</th>
    <td>

   <select name="status" class="form-control wd-450" required="true" >
   <option value="" hidden >Select Status</option>
     <option value="Approved">Approved</option>
     <option value="Decline">Decline</option>
     
   </select></td>
  </tr>
  <tr>
      <th>Message:</th>
      <td>
        <textarea name="message" id="" cols="65" rows="5" style="resize: none;"></textarea>
      </td>
     </tr>
</table>
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
 <button type="submit" name="submit" class="btn btn-primary">Update</button>
  
  </form>
  

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
</body>
</html>
<?php }  ?>