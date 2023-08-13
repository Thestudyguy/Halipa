<div class="modal fade" id="patients" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Patient Record</h4></center>
            </div>
            <div class="modal-body">	
            	<table  class="table table-bordered table-hover js-basic-example dataTable table-custom striped">
                    <thead>
                    <th>No</th>
						<th>Patient Name</th>
						<th>Birthdate</th>
						<th>Age</th>
						<th>Sex</th>
						<th>Mobile Number</th>
						<th>Address</th>
                    </thead>
                    <tbody>
                    <?php
							include_once('db_connection.php');
							$sql = "SELECT * FROM patient";

							
							$query = $conn->query($sql);
							while($row = $query->fetch_assoc()){
								echo 
								"<tr>
									<td>".$row['Patientid']."</td>
									<td>".$row['patientName']."</td>
									<td>".$row['birthdate']."</td>
									<td>".$row['age']."</td>
									<td>".$row['sex']."</td>
									<td>".$row['contactnumber']."</td>
									<td>".$row['address']."</td>
								</tr>";
							}
							

						?>
                    </tbody>
                </table>
			</div>
        </div>
    </div>
</div>