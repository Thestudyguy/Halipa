<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Add on Inventory</title>
     
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
  

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
</head>
<body>

    <div class="container">
    
        <div class="row justify-content-center">
        
            <div class="col-md-12">
            
                <div class="card mt-5">
                
                    <div class="card-header">
                
                        <h4>Inventory History</h4>

                    </div>
                    <div class="card-body">
                    <?php
include_once('db_connection.php');

// Function to get the previous version of edited material
function getPreviousVersion($materialId)
{
    global $conn;
    $sql = "SELECT * FROM material_edits WHERE material_id = $materialId ORDER BY id DESC LIMIT 1, 1";
    $query = $conn->query($sql);
    if ($query->num_rows > 0) {
        $row = $query->fetch_assoc();
        return $row;
    }
    return null;
}

?>

<!-- Display Deleted Materials -->
<div class="table-responsive">
    <hr>
    <span class="text-dark h2">Deleted Materials</span>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Material</th>
                <th>Quantity</th>
                <th>Purchase date</th>
                <th>Expiration date</th>
                <th>Deletion Reason</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Retrieve and display deleted materials
            $sqlDeleted = "SELECT * FROM deleted_materials";
            $queryDeleted = $conn->query($sqlDeleted);
            $cntDeleted = 1;
            while ($rowDeleted = $queryDeleted->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlentities($cntDeleted++) . "</td>";
                echo "<td>" . htmlentities($rowDeleted['name']) . "</td>";
                echo "<td>" . htmlentities($rowDeleted['quantity']) . "</td>";
                echo "<td>" . htmlentities($rowDeleted['purchasedate']) . "</td>";
                echo "<td>" . htmlentities($rowDeleted['expirationdate']) . "</td>";
                echo "<td>" . htmlentities($rowDeleted['deletion_reason']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Display Expired Materials -->
<div class="table-responsive">
    <hr>
    <span class="text-dark h2">Expired Materials</span>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Material</th>
                <th>Quantity</th>
                <th>Purchase date</th>
                <th>Expiration date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Retrieve and display expired materials
            $sqlExpired = "SELECT * FROM add_medicine WHERE expirationdate < NOW()";
            $queryExpired = $conn->query($sqlExpired);
            $cntExpired = 1;
            while ($rowExpired = $queryExpired->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlentities($cntExpired++) . "</td>";
                echo "<td>" . htmlentities($rowExpired['name']) . "</td>";
                echo "<td>" . htmlentities($rowExpired['quantity']) . "</td>";
                echo "<td>" . htmlentities($rowExpired['purchasedate']) . "</td>";
                echo "<td>" . htmlentities($rowExpired['expirationdate']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Display Edited Materials -->
<div class="table-responsive">
    <hr>
    <span class="text-dark h2">Edited Materials</span>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="5">Edited From</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Purchase Date</th>
                        <th>Expiration Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Retrieve and display edited materials with version history
                    $sqlEdited = "SELECT e.id as edit_id, e.material_id, e.name as new_name, e.quantity as new_quantity, e.purchasedate as new_purchasedate, e.expirationdate as new_expirationdate,
                                         p.name as prev_name, p.quantity as prev_quantity, p.purchasedate as prev_purchasedate, p.expirationdate as prev_expirationdate
                                  FROM material_edits e
                                  LEFT JOIN add_medicine p ON e.material_id = p.id
                                  WHERE NOT EXISTS (
                                      SELECT 1 FROM material_edits em
                                      WHERE em.material_id = e.material_id AND em.edit_date > e.edit_date
                                  )
                                  ORDER BY e.edit_date DESC";

                    $queryEdited = $conn->query($sqlEdited);
                    $cntEdited = 1;
                    while ($rowEdited = $queryEdited->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlentities($cntEdited++) . "</td>";
                        echo "<td>" . htmlentities($rowEdited['new_name']) . "</td>";
                        echo "<td>" . htmlentities($rowEdited['new_quantity']) . "</td>";
                        echo "<td>" . htmlentities($rowEdited['new_purchasedate']) . "</td>";
                        echo "<td>" . htmlentities($rowEdited['new_expirationdate']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="5">Edited To</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Purchase Date</th>
                        <th>Expiration Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Retrieve and display edited materials with version history
                    $sqlEdited = "SELECT e.id as edit_id, e.material_id, e.name as new_name, e.quantity as new_quantity, e.purchasedate as new_purchasedate, e.expirationdate as new_expirationdate,
                                         p.name as prev_name, p.quantity as prev_quantity, p.purchasedate as prev_purchasedate, p.expirationdate as prev_expirationdate
                                  FROM material_edits e
                                  LEFT JOIN add_medicine p ON e.material_id = p.id
                                  WHERE NOT EXISTS (
                                      SELECT 1 FROM material_edits em
                                      WHERE em.material_id = e.material_id AND em.edit_date > e.edit_date
                                  )
                                  ORDER BY e.edit_date DESC";

                    $queryEdited = $conn->query($sqlEdited);
                    $cntEdited = 1;
                    while ($rowEdited = $queryEdited->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlentities($cntEdited++) . "</td>";
                        echo "<td>" . htmlentities($rowEdited['prev_name']) . "</td>";
                        echo "<td>" . htmlentities($rowEdited['prev_quantity']) . "</td>";
                        echo "<td>" . htmlentities($rowEdited['prev_purchasedate']) . "</td>";
                        echo "<td>" . htmlentities($rowEdited['prev_expirationdate']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Display Used Materials -->
<div class="table-responsive">
    <hr>
    <span class="text-dark h2">Used Materials</span>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Patient Tool ID</th>
                <th>Patient ID</th>
                <th>Patient Name</th>
                <th>Tool Name</th>
                <th>Tool Quantity</th>
                <th>Service</th>
                <th>ID</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Retrieve and display used materials with additional details
            $sqlUsed = "SELECT pt.patient_tool_id, pt.patient_id, pt.ID, pt.tool_id, pt.quantity as tool_quantity,
                        pt.service, p.patientName, a.name as tool_name, s.servicename as service_name
                        FROM patient_tools pt
                        LEFT JOIN patient p ON pt.patient_id = p.Patientid
                        LEFT JOIN add_medicine a ON pt.tool_id = a.id
                        LEFT JOIN services s ON pt.service = s.id";

            $queryUsed = $conn->query($sqlUsed);
            $cntUsed = 1;
            while ($rowUsed = $queryUsed->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlentities($cntUsed++) . "</td>";
                echo "<td>" . htmlentities($rowUsed['patient_tool_id']) . "</td>";
                echo "<td>" . htmlentities($rowUsed['patient_id']) . "</td>";
                echo "<td>" . htmlentities($rowUsed['patientName']) . "</td>";
                echo "<td>" . htmlentities($rowUsed['tool_name']) . "</td>";
                echo "<td>" . htmlentities($rowUsed['tool_quantity']) . "</td>";
                echo "<td>" . htmlentities($rowUsed['service_name']) . "</td>";
                echo "<td>" . htmlentities($rowUsed['ID']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<a href="inventory.php" class="btn btn-success"><span class=""></span>Back</a>


                    </div>
                </div>

            </div>
        </div>
    </div>
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