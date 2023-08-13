<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $row['Patientid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Edit Patient Record</h4></center>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
			<form method="POST" action="editpatient.php">
				<input type="hidden" class="form-control" name="Patientid" value="<?php echo $row['Patientid']; ?>">
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Patient Name:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="patientName" value="<?php echo $row['patientName']; ?>">
					</div>
				</div>
				<div class="row form-group" hidden>
					<div class="col-sm-2">
						<label class="control-label modal-label">Patient Name:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="firstname" value="<?php echo $row['patientName']; ?>">
					</div>
				</div>
				 <div class="row form-group" hidden>
					<div class="col-sm-2">
						<label class="control-label modal-label">Lastname:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="lastname" value="<?php echo $row['lastname']; ?>">
					</div>
				</div>
				<div class="row form-group" hidden>
					<div class="col-sm-2">
						<label class="control-label modal-label">Middilename:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="middlename" value="<?php echo $row['middlename']; ?>">
					</div>
				</div> 
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Birthdate:</label>
					</div>
					<div class="col-sm-10">
						<input type="date" class="form-control" name="birthdate" value="<?php echo $row['birthdate']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Age:</label>
					</div>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="age" value="<?php echo $row['age']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Sex:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="sex" value="<?php echo $row['sex']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Religion:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="religion" value="<?php echo $row['religion']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Nationality:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nationality" value="<?php echo $row['nationality']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Status:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="status" value="<?php echo $row['status']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Contact Number:</label>
					</div>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="contactnumber" value="<?php echo $row['contactnumber']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Address:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="address" value="<?php echo $row['address']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Occupation:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="occupation" value="<?php echo $row['occupation']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Dental Insurance:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="dentalinsurance" value="<?php echo $row['dentalinsurance']; ?>">
					</div>
				</div>
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <button type="submit" name="edit" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Update</a>
			</form>
            </div>

        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete_<?php echo $row['Patientid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Delete Patient Record</h4></center>
            </div>
            <div class="modal-body">	
            	<p class="text-center">Are you sure you want to Delete</p>
				<h2 class="text-center"><?php echo $row['patientName']?></h2>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <a href="deletepatient.php?Patientid=<?php echo $row['Patientid']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Yes</a>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editModal-<?php echo $row['Email']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Edit Patient Record</h4></center>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
			<form method="POST" action="editpatient.php">
				<input type="hidden" class="form-control" name="Patientid" value="<?php echo $row['Patientid']; ?>">
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Patient Name:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="patientName" value="<?php echo $row['patientName']; ?>">
					</div>
				</div>
				<div class="row form-group" hidden>
					<div class="col-sm-2">
						<label class="control-label modal-label">Patient Name:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="firstname" value="<?php echo $row['patientName']; ?>">
					</div>
				</div>
				 <div class="row form-group" hidden>
					<div class="col-sm-2">
						<label class="control-label modal-label">Lastname:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="lastname" value="<?php echo $row['lastname']; ?>">
					</div>
				</div>
				<div class="row form-group" hidden>
					<div class="col-sm-2">
						<label class="control-label modal-label">Middilename:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="middlename" value="<?php echo $row['middlename']; ?>">
					</div>
				</div> 
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Birthdate:</label>
					</div>
					<div class="col-sm-10">
						<input type="date" class="form-control" name="birthdate" value="<?php echo $row['birthdate']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Age:</label>
					</div>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="age" value="<?php echo $row['age']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Sex:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="sex" value="<?php echo $row['sex']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Religion:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="religion" value="<?php echo $row['religion']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Nationality:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nationality" value="<?php echo $row['nationality']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Status:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="status" value="<?php echo $row['status']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Contact Number:</label>
					</div>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="contactnumber" value="<?php echo $row['contactnumber']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Address:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="address" value="<?php echo $row['address']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Occupation:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="occupation" value="<?php echo $row['occupation']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Dental Insurance:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="dentalinsurance" value="<?php echo $row['dentalinsurance']; ?>">
					</div>
				</div>
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <button type="submit" name="edit" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Update</a>
			</form>
            </div>

        </div>
    </div>
</div>
