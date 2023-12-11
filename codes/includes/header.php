
<?php
session_start();
error_reporting(0);
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

<nav id="app-navbar" class="navbar navbar-inverse navbar-fixed-top primary">
  
  <!-- navbar header -->
  <div class="navbar-header">
    <button type="button" id="menubar-toggle-btn" class="navbar-toggle visible-xs-inline-block navbar-toggle-left hamburger hamburger--collapse js-hamburger">
      <span class="sr-only">Toggle navigation</span>
      <span class="hamburger-box"><span class="hamburger-inner"></span></span>
    </button>

    <button type="button" class="navbar-toggle navbar-toggle-right collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="zmdi zmdi-hc-lg zmdi-more"></span>
    </button>

    <button type="button" class="navbar-toggle navbar-toggle-right collapsed" data-toggle="collapse" data-target="#navbar-search" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="zmdi zmdi-hc-lg zmdi-search"></span>
    </button>

    <a href="dashboard.php" class="navbar-brand">
     <img src="images/halipagray.png" width="150px" height="50px"></a>
      
      
     
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
        <li class="hidden-float hidden-menubar-top">
          <a href="javascript:void(0)" role="button" id="menubar-fold-btn" class="hamburger hamburger--arrowalt is-active js-hamburger">
            <span class="hamburger-box"><span class="hamburger-inner"></span></span>
          </a>
        </li>
        <li>
          <h5 class="page-title hidden-menubar-top hidden-float"></h5>
        </li>
      </ul>

      <ul class="nav navbar-toolbar navbar-toolbar-right navbar-right">
       
<?php 

$sql = "SELECT COUNT(*) as new_appointments FROM tblappointment WHERE Status IS NULL";
$query = $dbh->prepare($sql);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);
$newAppointmentsCount = $result['new_appointments'];
?>
<!-- <span class="notification-badge" style="background-color: red; color: white; border-radius: 70%; padding: 1px 6px; font-size: 12px; position: absolute; top: 3px; right: 0;">1</span> -->
        <li class="dropdown">
          <?php
          if($isAdminUser):
          ?>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <?php endif;?>
  <?php 
  if ($newAppointmentsCount > 0) {
    if($isAdminUser):

    echo '<span class="notification-badge" style="background-color: red; color: white; border-radius: 70%; padding: 1px 6px; font-size: 12px; position: absolute; top: 3px; right: 0;">' . $newAppointmentsCount . '</span>';
    endif;

  }
  ?>
   <?php
          if($isAdminUser):
          ?>
 <i class="zmdi zmdi-hc-lg zmdi-notifications" <?php echo ' title="'.$newAppointmentsCount.' new appointment"' ?> ></i>
  <?php endif;?>
          <ul class="dropdown-menu animated flipInY">
           
            <?php
							include_once('db_connection.php');
            $sql = "SELECT * FROM tblappointment WHERE Status IS NULL";
            $query = $conn->query($sql);
            while($row = $query->fetch_assoc()){
              echo '
              <div class="containerss" style="cursor: pointer;"  onclick="redirectToAppointmentDetails(' . $row['ID'] . ', ' . $row['AppointmentNumber'] . ')">
              <a class="p-5 text-capitalize text-primary"></a>
              <div class="notification-icon"><span></span></div>
              <div class="notification">
               <b style="color: #16161D;">new appointment</b>  <br>
            '.$row['Name'].'
            <br> '.$row['AppointmentDate'].' - '.date('h:i A', strtotime($row['AppointmentTime'])).' 
              </div>
            
            </div>';
            }
            echo '
<script>
    function redirectToAppointmentDetails(editid, aptid) {
        var url = "view-appointment-detail.php?editid=" + encodeURIComponent(editid) + "&aptid=" + encodeURIComponent(aptid);
        window.location.href = url;
    }
</script>';
     //endif;
     ?>
          
          </ul>
          <!-- <li class="p-5">from:  '.$row['Name'].'</li> -->
</a>

          <div class="media-group dropdown-menu animated flipInY">
         <?php

         $docid=$_SESSION['damsid'];
$sql="SELECT * from tblappointment  where Status is null && Doctor=:docid";
$query = $dbh -> prepare($sql);
$query-> bindParam(':docid', $docid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
$totalappintments=$query->rowCount();
foreach($results as $row)
{ 

  ?>

            <a href="view-appointment-detail.php?editid=<?php echo $row->ID;?>&&aptid=<?php echo $row->AppointmentNumber;?>" class="media-group-item">
              <div class="media">
                <div class="media-left">
                  <div class="avatar avatar-xs avatar-circle">
                    <img src="assets/images/images.png" alt="">
                    <i class="status status-online"></i>
                  </div>
                </div>
                <div class="media-body">
                  <h5 class="media-heading">NEW APPOINTMENT</h5>
                  <small class="media-meta"><?php echo $row->AppointmentNumber;?> at (<?php echo $row->ApplyDate;?>)</small>
                </div>
              </div>
            </a><!-- .media-group-item -->
        <?php  } ?>
          </div>
        </li>

        <li class="dropdown">
          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-hc-lg zmdi-settings"></i></a>
          <ul class="dropdown-menu animated flipInY">
          <?php if ($isAdminUser) : ?>
             <li> <a href="accounts.php"><i class="zmdi m-r-md zmdi-hc-lg zmdi-accounts-add"></i>Accounts</a></li>
              
            <?php endif; ?>
            
            <li><a href="logout.php"><i class="zmdi m-r-md zmdi-hc-lg zmdi-sign-in"></i>Logout</a></li>

           
          </ul>
        </li>

      </ul>
    </div>
  </div><!-- navbar-container -->
  <style>
              .containerss{
                color: #16161D;
                text-transform: uppercase;
                font-size: 12px;
  display: flex;
  border-top: 1px solid whitesmoke;
  padding: 5px
  transition: .3s ease-in-out;
}
.containerss:hover{
  background-color: whitesmoke;
}
.notification-icon{
  width:10px;
  height:10px;
  border-radius: 50%;
  background-color: red;
}
             
            </style>
</nav>