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

<aside id="menubar" class="menubar light" style="overflow: hidden;">
  <br>
  <br>
  <div class="app-user">
    <div class="media">
      <div class="media-left">
        <div class="avatar avatar-md avatar-circle">
          <a href="javascript:void(0)"><img class="img-responsive" src="assets/images/icon.png" alt="avatar"/></a>
        </div><!-- .avatar -->
      </div>
      <div class="media-body">
        <div class="foldable">
          <h5><a href="javascript:void(0)" class="username"><?php  echo $fname ;?></a></h5>
          <ul>
            <li class="dropdown">
              <a href="javascript:void(0)" class="dropdown-toggle usertitle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <small><?php  echo $email;?></small>
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu animated flipInY">
                <li>
                  <a class="text-color" href="dashboard.php">
                    <span class="m-r-xs"><i class="fa fa-home"></i></span>
                    <span>Home</span>
                  </a>
                  <?php if ($isAdminUser) : ?>
               <li>
                <a class="text-color" href="accounts.php">
                 <span class="m-r-xs"><i class="zmdi zmdi-accounts-add"></i></span>
                 <span class="menu-text">Accounts</span>
                </a>
              </li>
                 <?php endif; ?>
                </li>
                <li role="separator" class="divider"></li>
                <li>
                  <a class="text-color" href="logout.php">
                    <span class="m-r-xs"><i class="zmdi zmdi-sign-in"></i></span>
                    <span>logout</span>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div><!-- .media-body -->
    </div><!-- .media -->
  </div><!-- .app-user -->

  <div class="menubar-scroll">
    <div class="menubar-scroll-inner">
      <ul class="app-menu">
        <?php if ($isAdminUser) : ?>
          <li class="has-submenu">
            <a href="dashboard.php">
              <i class="menu-icon zmdi zmdi-view-dashboard zmdi-hc-lg"></i>
              <span class="menu-text">Dashboard</span>
            </a>
          </li>

          <li class="has-submenu">
            <a href="javascript:void(0)" class="submenu-toggle">
              <i class="menu-icon zmdi zmdi-pages zmdi-hc-lg"></i>
              <span class="menu-text">Appointment</span>
              <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
            </a>
            <ul class="submenu">
              <li><a href="new-appointment.php"><span class="menu-text">New Appointment</span></a></li>
              <li><a href="approved-appointment.php"><span class="menu-text">Approved Appointment</span></a></li>
              <li><a href="cancelled-appointment.php"><span class="menu-text">Decline Appointment</span></a></li>
              <li><a href="all-appointment.php"><span class="menu-text">All Appointment</span></a></li>
              <li><a href="appointment-bwdates.php"><span class="menu-text">Appointment Report</span></a></li>
              <li><a href="search.php"><span class="menu-text">Search Appointment</span></a></li>
            </ul>
          </li>
        <?php endif; ?>

       
        <li>
          <a href="patient.php">
            <i class="menu-icon zmdi zmdi-accounts-add zmdi-hc-lg"></i>
            <span class="menu-text">Patient</span>
          </a>
        </li>
        <?php if ($isAdminUser) : ?>
        <li>
          <a href="invoice.php">
            <i class="menu-icon zmdi zmdi-card zmdi-hc-lg"></i>
            <span class="menu-text">Invoice</span>
          </a>
        </li>
        <?php endif; ?>

          <li>
            <a href="services.php">
              <i class="menu-icon zmdi zmdi-format-list-bulleted zmdi-hc-lg"></i>
              <span class="menu-text">Services</span>
            </a>
          </li>
         

        <li>
          <a href="inventory.php">
            <i class="menu-icon zmdi zmdi-inbox zmdi-hc-lg"></i>
            <span class="menu-text">Inventory</span>
          </a>
        </li>
        <?php if ($isAdminUser) : ?>
        <li>
          <a href="sales.php">
            <i class="menu-icon zmdi zmdi-receipt zmdi-hc-lg"></i>
            <span class="menu-text">Sales Report</span>
          </a>
        </li>
        <?php endif; ?>
        
      </ul><!-- .app-menu -->
    </div><!-- .menubar-scroll-inner -->
  </div><!-- .menubar-scroll -->
  
</aside>
<?php


?>