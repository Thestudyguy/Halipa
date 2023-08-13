
<!-- //periodontonics -->
<style>
    .status-pending {
        color: red;
    }
</style>
<div class="modal fade" id="Periodontics" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Service Report</h4></center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <h3>Periodontics</h3>
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Patient Name</th>
                                <th>Appointment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT a.Name AS PatientName, COALESCE(a.Status, 'Pending') AS Status
                            FROM tblappointment a
                            INNER JOIN services s ON a.Specialization = s.id
                            WHERE s.servicename = 'Periodontics' ORDER BY a.Status ASC";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $count=1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    $statusClass = $row->Status === 'Pending' ? 'status-pending' : ''; // Add class based on status
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($count++); ?></td>
                                        <td><?php echo htmlentities($row->PatientName); ?></td>
                                        <td class="<?php echo $statusClass; ?>"><?php echo htmlentities($row->Status); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td>No patients available for Periodontics service.</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Total Sales</th>
                                <th>Total Patient</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                          $sql = "SELECT s.servicename AS Service,
                          s.price AS Price,
                          SUM(s.price) AS TotalSales,
                          COUNT(*) AS TotalPatients
                  FROM tblappointment a
                  INNER JOIN services s ON a.Specialization = s.id
                  WHERE a.Status = 'Approved' AND s.servicename = 'Periodontics'
                  GROUP BY s.servicename";
          
           
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($row->Service); ?></td>
                                        <td><?php echo htmlentities(number_format($row->Price)); ?></td>
                                        <td><?php echo htmlentities(number_format($row->TotalSales)); ?></td>
                                        <td><?php echo htmlentities($row->TotalPatients); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">No data available</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //Surgery -->
<div class="modal fade" id="Surgery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Service Report</h4></center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <h3>Surgery</h3>
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Patient Name</th>
                                <th>Appointment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT a.Name AS PatientName, COALESCE(a.Status, 'Pending') AS Status
                            FROM tblappointment a
                            INNER JOIN services s ON a.Specialization = s.id
                            WHERE s.servicename = 'Surgery' ORDER BY a.Status ASC";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $count=1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    $statusClass = $row->Status === 'Pending' ? 'status-pending' : ''; // Add class based on status
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($count++); ?></td>
                                        <td><?php echo htmlentities($row->PatientName); ?></td>
                                        <td class="<?php echo $statusClass; ?>"><?php echo htmlentities($row->Status); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td>No patients available for Surgery service.</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Total Sales</th>
                                <th>Total Patient</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                           $sql = "SELECT s.servicename AS Service,
                           s.price AS Price,
                           SUM(s.price) AS TotalSales,
                           COUNT(*) AS TotalPatients
                   FROM tblappointment a
                   INNER JOIN services s ON a.Specialization = s.id
                   WHERE a.Status = 'Approved' AND s.servicename = 'Surgery'
                   GROUP BY a.Specialization";
           
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($row->Service); ?></td>
                                        <td><?php echo htmlentities(number_format($row->Price)); ?></td>
                                        <td><?php echo htmlentities(number_format($row->TotalSales)); ?></td>
                                        <td><?php echo htmlentities($row->TotalPatients); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">No data available</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //Endodontics -->
<div class="modal fade" id="Endodontics" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Service Report</h4></center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <h3>Endodontics</h3>
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Patient Name</th>
                                <th>Appointment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             $sql = "SELECT a.Name AS PatientName, COALESCE(a.Status, 'Pending') AS Status
                             FROM tblappointment a
                             INNER JOIN services s ON a.Specialization = s.id
                             WHERE s.servicename = 'Endodontics' ORDER BY a.Status ASC";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $count=1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    $statusClass = $row->Status === 'Pending' ? 'status-pending' : ''; // Add class based on status
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($count++); ?></td>
                                        <td><?php echo htmlentities($row->PatientName); ?></td>
                                        <td class="<?php echo $statusClass; ?>"><?php echo htmlentities($row->Status); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td>No patients available for Endodontics service.</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Total Sales</th>
                                <th>Total Patient</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                           $sql = "SELECT s.servicename AS Service,
                           s.price AS Price,
                           SUM(s.price) AS TotalSales,
                           COUNT(*) AS TotalPatients
                   FROM tblappointment a
                   INNER JOIN services s ON a.Specialization = s.id
                   WHERE a.Status = 'Approved' AND s.servicename = 'Endodontics'
                   GROUP BY a.Specialization";
           
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($row->Service); ?></td>
                                        <td><?php echo htmlentities(number_format($row->Price)); ?></td>
                                        <td><?php echo htmlentities(number_format($row->TotalSales)); ?></td>
                                        <td><?php echo htmlentities($row->TotalPatients); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">No data available</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- //Restorative -->
<div class="modal fade" id="Restorative" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Service Report</h4></center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <h3>Restorative</h3>
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Patient Name</th>
                                <th>Appointment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT a.Name AS PatientName, COALESCE(a.Status, 'Pending') AS Status
                            FROM tblappointment a
                            INNER JOIN services s ON a.Specialization = s.id
                            WHERE s.servicename = 'Restorative' ORDER BY a.Status ASC";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $count=1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    $statusClass = $row->Status === 'Pending' ? 'status-pending' : ''; // Add class based on status
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($count++); ?></td>
                                        <td><?php echo htmlentities($row->PatientName); ?></td>
                                        <td class="<?php echo $statusClass; ?>"><?php echo htmlentities($row->Status); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td>No patients available for Restorative service.</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Total Sales</th>
                                <th>Total Patient</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                           $sql = "SELECT s.servicename AS Service,
                           s.price AS Price,
                           SUM(s.price) AS TotalSales,
                           COUNT(*) AS TotalPatients
                   FROM tblappointment a
                   INNER JOIN services s ON a.Specialization = s.id
                   WHERE a.Status = 'Approved' AND s.servicename = 'Restorative'
                   GROUP BY a.Specialization";
           
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($row->Service); ?></td>
                                        <td><?php echo htmlentities(number_format($row->Price)); ?></td>
                                        <td><?php echo htmlentities(number_format($row->TotalSales)); ?></td>
                                        <td><?php echo htmlentities($row->TotalPatients); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">No data available</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- //Orthodontics -->
<div class="modal fade" id="Orthodontics" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Service Report</h4></center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <h3>Orthodontics</h3>
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Patient Name</th>
                                <th>Appointment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           $sql = "SELECT a.Name AS PatientName, COALESCE(a.Status, 'Pending') AS Status
                           FROM tblappointment a
                           INNER JOIN services s ON a.Specialization = s.id
                           WHERE s.servicename = 'Orthodontics' ORDER BY a.Status ASC";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $count=1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    $statusClass = $row->Status === 'Pending' ? 'status-pending' : ''; // Add class based on status
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($count++); ?></td>
                                        <td><?php echo htmlentities($row->PatientName); ?></td>
                                        <td class="<?php echo $statusClass; ?>"><?php echo htmlentities($row->Status); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td>No patients available for Orthodontics service.</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Total Sales</th>
                                <th>Total Patient</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                           $sql = "SELECT s.servicename AS Service,
                           s.price AS Price,
                           SUM(s.price) AS TotalSales,
                           COUNT(*) AS TotalPatients
                   FROM tblappointment a
                   INNER JOIN services s ON a.Specialization = s.id
                   WHERE a.Status = 'Approved' AND s.servicename = 'Orthodontics'
                   GROUP BY a.Specialization";
           
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($row->Service); ?></td>
                                        <td><?php echo htmlentities(number_format($row->Price)); ?></td>
                                        <td><?php echo htmlentities(number_format($row->TotalSales)); ?></td>
                                        <td><?php echo htmlentities($row->TotalPatients); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">No data available</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- //Prosthodontics -->
<div class="modal fade" id="Prosthodontics" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Service Report</h4></center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <h3>Prosthodontics</h3>
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Patient Name</th>
                                <th>Appointment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             $sql = "SELECT a.Name AS PatientName, COALESCE(a.Status, 'Pending') AS Status
                             FROM tblappointment a
                             INNER JOIN services s ON a.Specialization = s.id
                             WHERE s.servicename = 'Prosthodontics' ORDER BY a.Status ASC";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $count=1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    $statusClass = $row->Status === 'Pending' ? 'status-pending' : ''; // Add class based on status
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($count++); ?></td>
                                        <td><?php echo htmlentities($row->PatientName); ?></td>
                                        <td class="<?php echo $statusClass; ?>"><?php echo htmlentities($row->Status); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td>No patients available for Prosthodontics service.</td>
                                </tr>
                                <?php
                            }
                            ?>
                            
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Total Sales</th>
                                <th>Total Patient</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                           $sql = "SELECT s.servicename AS Service,
                           s.price AS Price,
                           SUM(s.price) AS TotalSales,
                           COUNT(*) AS TotalPatients
                   FROM tblappointment a
                   INNER JOIN services s ON a.Specialization = s.id
                   WHERE a.Status = 'Approved' AND s.servicename = 'Prosthodontics'
                   GROUP BY a.Specialization";
           
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($row->Service); ?></td>
                                        <td><?php echo htmlentities(number_format($row->Price)); ?></td>
                                        <td><?php echo htmlentities(number_format($row->TotalSales)); ?></td>
                                        <td><?php echo htmlentities($row->TotalPatients); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">No data available</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //Total Sales -->
<div class="modal fade" id="serviceSales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Service Sales Report</h4></center>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                     <!-- <li class="active"><a href="#service-report-tab" data-toggle="tab">Appointment Report</a></li> -->
                    <li><a href="#invoice-report-tab" data-toggle="tab">Invoice Report</a></li>
                    <!-- <li><a href="#patient-report-tab" data-toggle="tab">Patient Report</a></li> -->
                </ul>
                <div class="tab-content">
                

                    <div class="tab-pane fade" id="invoice-report-tab">
                    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Service</th>
            <th>Price</th>
            <th>Total Patients</th>
            <th>Total Sales</th>
        </tr>
    </thead>
    <tbody>
        <?php
       $sql2 = "SELECT s.servicename AS Service,
       s.price AS Price,
       COALESCE(SUM(s.price), 0) AS TotalSales,
       COALESCE(COUNT(*), 0) AS TotalPatients
   FROM services s
   LEFT JOIN invoice i ON i.Service = s.id
   GROUP BY s.id";

        $query2 = $dbh->prepare($sql2);
        $query2->execute();
        $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
        $totalInvoiceSales = 0;
        $totalPatients = 0;

        foreach ($results2 as $row2) {
            $totalSales += $row2->TotalSales;
            $totalInvoiceSales += $row2->TotalSales;
            $totalPatients += $row2->TotalPatients;
            ?>
            <tr>
                <td><?php echo htmlentities($row2->Service); ?></td>
                <td><?php echo htmlentities(number_format($row2->Price)); ?></td>
                <td><?php echo htmlentities($row2->TotalPatients); ?></td>
                <td><?php echo htmlentities(number_format($row2->TotalSales)); ?></td>
            </tr>
            <?php
        }

        if (empty($results2)) {
            ?>
            <tr>
                <td colspan="4">No data available</td>
            </tr>
            <?php
        }
        ?>
   
        <tr>
            <td colspan="3" style="text-align: left;"><strong>Total Invoice Sales:</strong></td>
            <td><strong><?php echo htmlentities(number_format($totalInvoiceSales)); ?></strong></td>
        </tr>
    </tbody>
</table>

                    </div>
                    
</div>
<div class="total-sales">
<hr>
<table class="table table-bordered">
<tr>
    <td colspan="3" style="text-align: left;"><strong>Total Sales:</strong></td>
    <td> <strong><?php echo htmlentities(number_format($totalSales + $totalPatientSales)); ?></strong> </td>
</tr>
</table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- view report -->
<!-- Modal for Viewing Report -->
<div class="modal fade" id="viewReportModal" tabindex="-1" role="dialog" aria-labelledby="viewReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewReportModalLabel">View Report</h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <!-- <li class="active"><a href="#patient-info-tab" data-toggle="tab">Patient Information</a></li> -->
                    <li><a href="#invoice-info-tab" data-toggle="tab">Invoice Information</a></li>
                </ul>

                <div class="tab-content">
                    <!-- Tab for Patient Information -->
                    

                    <!-- Tab for Invoice Information -->
                    <div class="tab-pane fade" id="invoice-info-tab">
                    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Service</th>
            <th>Price</th>
            <th>Patient Name</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
       $sql2 = "SELECT
       s.servicename AS Service,
       s.price AS Price,
       i.PatientName,
       i.InvoiceDate
     FROM
       services s
     INNER JOIN
       invoice i ON s.id = i.Service";
        $query2 = $conn->query($sql2);
        if (!$query2) {
            die("Error in SQL query: " . $conn->error);
        }

        if ($query2->num_rows === 0) {
            echo "<tr><td colspan='3'>No Paid Invoices Found</td></tr>";
        } else {
            while ($row = $query2->fetch_assoc()) {
        ?>
                <tr>
                    <td><?php echo htmlentities($row['Service']); ?></td>
                    <td><?php echo htmlentities($row['Price']); ?></td>
                    <td><?php echo htmlentities($row['PatientName']); ?></td>
                    <td><?php echo htmlentities($row['InvoiceDate']); ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<style>
    /* Custom CSS for the modal */
    .modal-dialog {
        max-height: 800px; /* Set your desired maximum height here */
        overflow-y: auto; /* Enable vertical scroll when content exceeds the height */
    }
</style>
<!-- Button to Trigger the Modal -->
<a href="#viewReportModal" data-toggle="modal" class="btn btn-primary">View Report</a>

<!-- unuse stuff -->
<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Service Report</h4></center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <!-- Navigation tabs for each service -->
                    <ul class="nav nav-tabs">
                        <?php
                        $sql = "SELECT servicename, id FROM services";
                        $query = $conn->query($sql);
                        $count = 1;
                        while ($row = $query->fetch_assoc()) {
                            $servicename = $row['servicename'];
                            $serviceID = $row['id'];
                            ?>
                            <li <?php if ($count === 1) echo 'class="active"'; ?>>
                                <a data-toggle="tab" href="#service-<?php echo $serviceID; ?>"> <b><?php echo $servicename; ?></b> </a>
                            </li>
                            <?php
                            $count++;
                        }
                        ?>
                    </ul>

                    <!-- Tab content for each service -->
                    <div class="tab-content">
                        <?php
                        $query = $conn->query($sql);
                        $count = 1;
                        while ($row = $query->fetch_assoc()) {
                            $servicename = $row['servicename'];
                            $serviceID = $row['id'];

                            // Fetch service-specific data for the first table
                            $sql1 = "SELECT a.Name AS PatientName, COALESCE(a.Status, 'Pending') AS Status
                                     FROM tblappointment a
                                     INNER JOIN services s ON a.Specialization = s.id
                                     WHERE s.id = $serviceID ORDER BY a.Status ASC";

                            $query1 = $dbh->prepare($sql1);
                            $query1->execute();
                            $results1 = $query1->fetchAll(PDO::FETCH_OBJ);

                            // Fetch service-specific data for the second table
                            $sql2 = "SELECT s.servicename AS Service,
                                            s.price AS Price,
                                            SUM(s.price) AS TotalSales,
                                            COUNT(*) AS TotalPatients
                                     FROM tblappointment a
                                     INNER JOIN services s ON a.Specialization = s.id
                                     WHERE a.Status = 'Approved' AND s.id = $serviceID
                                     GROUP BY a.Specialization";

                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                            ?>
                            <div id="service-<?php echo $serviceID; ?>" class="tab-pane fade <?php if ($count === 1) echo 'in active'; ?>">
                                <h3><?php echo $servicename; ?></h3>

                                <!-- Table 1: Service-specific patient data -->
                                <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Patient Name</th>
                                            <th>Appointment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        if (count($results1) > 0) {
                                            foreach ($results1 as $row1) {
                                                $statusClass = $row1->Status === 'Pending' ? 'status-pending' : '';
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($count++); ?></td>
                                                    <td><?php echo htmlentities($row1->PatientName); ?></td>
                                                    <td class="<?php echo $statusClass; ?>"><?php echo htmlentities($row1->Status); ?></td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="3">No patients available for this service.</td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <hr>
                                <!-- Table 2: Service-specific total sales and patient count -->
                                <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Price</th>
                                            <th>Total Sales</th>
                                            <th>Total Patient</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($results2) > 0) {
                                            foreach ($results2 as $row2) {
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($row2->Service); ?></td>
                                                    <td><?php echo htmlentities(number_format($row2->Price)); ?></td>
                                                    <td><?php echo htmlentities(number_format($row2->TotalSales)); ?></td>
                                                    <td><?php echo htmlentities($row2->TotalPatients); ?></td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="4">No data available</td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            $count++;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>