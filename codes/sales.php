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
  
  <title>Sales Report</title>
 
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
  <script src="jquery/jquery.min.js"></script>

<script src="datatable/jquery.dataTables.min.js"></script>
<script src="datatable/dataTable.bootstrap.min.js"></script>


  
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
     
      <div class="col-md-12">
        <div class="widget">
          <header class="widget-header">
            <h3 class="widget-title">SALES REPORT</h3>
          </header><!-- .widget-header -->
          <hr class="widget-separator">
          <div class="widget-body">
          <div class="table-responsive">
							

          <form method="POST">
        <section class="content-header  no-print">
       <div class="col-md-3"> </div>
       <div class="col-md-6"> 
           <div class="panel">
               <div class="panel-header"></div>
                   <div class="panel-body ">  
                        <div class="row">
                         <div class="col-sm-6 search1 ">
                           <label class="col-sm-5">Date From:</label>
                           <div class="col-sm-9">
                             <div class="input-group date">
                               <div class="input-group-addon">
                               
                               </div>
                               
                               <input required autocomplete="off" type="date" value="" name="date_from" class="form-control pull-right date_picker" id="datemask2" placeholder="mm/dd/yyyy">
                             </div>
                           </div>
                         </div>
                       </div>   
                        <div class="row">
                         <div class="col-sm-6 search1">
                           <label class="col-sm-5">Date To:</label>
                           <div class="col-sm-9">
                             <div class="input-group date">
                               <div class="input-group-addon">

                               </div>
                               <input required autocomplete="off" type="date" value="" name="date_to" class="form-control pull-right date_picker" id="datemask2" placeholder="mm/dd/yyyy">
                             </div>
                           </div>
                         </div>
                       </div>   
                         <div class="row">
                         <div class="col-sm-12 search1">
                           <label class="col-sm-3"></label>
                           <div class="col-sm-9">
                            <br>
                              <input type="submit" name="submit" class="btn btn-success">
                           </div>
                         </div>
                       </div>  
                   </div>
           </div> 
           
       </div> 

       <div class="col-md-3"> </div>
   </section> 

   </form>
   <div class="clear"></div>
  <section class="content col-sm-12">
 
  	<p style="text-align: center;font-size: 15px"><br>
	Sales Report <br/>
	As of <?php echo date('m/d/Y');?>

 
	 

	 <p  style="font-size:15px;text-align: center;">
    Inclusive Dates: <?php echo isset($_POST['date_from']) ? "From : " .$_POST['date_from'] : "Month-Day-Year" ?> | <?php echo isset($_POST['date_to']) ? " To : " .$_POST['date_to'] : "Month-Day-Year" ?></p>
  </p>
  	  
  
<br>


<!-- Step 2: Display the sales report in a Bootstrap-styled table -->
<div class="table-responsive">
<?php
include_once('db_connection.php'); // Include your database connection

if(isset($_POST['submit'])) {
    $dateFrom = $_POST['date_from'];
    $dateTo = $_POST['date_to'];

    // Check if both date fields are not empty
    if (!empty($dateFrom) && !empty($dateTo)) {
        // Query to retrieve data within the selected date range and join with services table
        $sql = "SELECT sv.servicename, sv.price, COUNT(sr.Service) AS totalPatients, SUM(sv.price) AS totalSales
                FROM sales_report sr
                INNER JOIN services sv ON sr.Service = sv.id
                WHERE sr.Date BETWEEN '$dateFrom' AND '$dateTo'
                GROUP BY sr.Service";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Services</th>';
            echo '<th>Price</th>';
            echo '<th>Total Patients</th>';
            echo '<th>Total Sales</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $totalSales = 0;

            while($row = $result->fetch_assoc()) {
              $data[] = $row;
                echo '<tr>';
                echo '<td>' . $row["servicename"] . '</td>';
                echo '<td>' . $row["price"] . '</td>';
                echo '<td>' . $row["totalPatients"] . '</td>';
                echo '<td>' . $row["totalSales"] . '</td>';
                echo '</tr>';

                $totalSales += $row["totalSales"];
                include_once('salesReportPDF.php');
            }

            echo '</tbody>';
            echo '<tfoot>';
            echo '<tr>';
            echo '<th colspan="3">Total Sales</th>';
            echo '<th>' . $totalSales . '</th>';
            echo '</tr>';
            echo '</tfoot>';
            echo '</table>';
            
            // Add a button to generate PDF
            echo '<form method="post" action="salesReportPDF.php" target="_blank">';
echo '<input type="hidden" name="data" value=\'' . htmlspecialchars(json_encode($data)) . '\'>';
echo '<button type="submit" class="btn btn-primary">Generate PDF</button>';
echo '</form>';
        } else {
            echo "No results found.";
        }
        $_SESSION['date_from'] = $_POST['date_from'];
        $_SESSION['date_to'] = $_POST['date_to'];
    } else {
        echo "Please enter both date values.";
    }
}
?>



</div>

        </tbody>
    </table>
</div>

        </tbody>
    </table>
</div>


  		
  	
  </table>
          </div><!-- .widget-body -->
        </div><!-- .widget -->
      </div><!-- END column -->

    </div><!-- .row -->
  </section><!-- #dash-content -->
</div><!-- .wrap -->
  <!-- APP FOOTER -->
  <?php include_once('includes/footer.php');?>
  <!-- /#app-footer -->
</main>
<?php include('add_modal_patient.php') ?>

<!--========== END app main -->
<script>
$(document).ready(function(){
	
    $('#myTable').DataTable();

    
    $(document).on('click', '.close', function(){
    	$('.alert').hide();
    })
});
</script>
<?php include_once('includes/customizer.php');?>
  
  <!-- SIDE PANEL -->


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