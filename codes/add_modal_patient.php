<!-- Add New -->
<div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Add New Patient</h4></center>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
			<form method="POST" action="addpatient.php">
				<!-- <div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Firstname:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="firstname" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Lastname:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="lastname" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Middlename:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="middlename" required>
					</div>
				</div> -->
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Patient Name: </label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="patientName" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Birhtdate</label>
					</div>
					<div class="col-sm-10">
						<input type="date" class="form-control" name="birthdate" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Age:</label>
					</div>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="age" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Sex:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="sex" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Religion:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="religion" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Nationality:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nationality" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Status:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="status" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Contact Number:</label>
					</div>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="contactnumber" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Address:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="address" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Occupation:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="occupation" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Dental Insurance:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="dentalinsurance" required>
					</div>
				</div>
				
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <button type="submit" name="add" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
			</form>
            </div>

        </div>
    </div>
</div>