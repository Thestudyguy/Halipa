<div class="modal fade" id="edit_<?php echo $row['InvoiceNumber']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Edit Invoice</h4></center>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
			<form method="POST" action="editInvoiceQuery.php">
            <div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Invoice Number:</label>
					</div>
					<div class="col-sm-10">
                    <input style="cursor: not-allowed;" type="text" name="invoiceNumber" class="form-control" autocomplete="off" value="<?php echo $row['InvoiceNumber'];?>" readonly='true'>
                </div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Patient Name:</label>
					</div>
					<div class="col-sm-10">
                    <input type="text" name="patientName" class="form-control" autocomplete="off" value="<?php echo $row['PatientName'];?>">
                </div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Date:</label>
					</div>
					<div class="col-sm-10">
						<input type="date" class="form-control" name="date" value="<?php echo $row['InvoiceDate'];?>">
					</div>
				</div>
				<!-- <div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Due Date:</label>
					</div>
					<div class="col-sm-10">
						<input type="date" class="form-control" name="dueDate" value="<?php echo $row['InvoiceDueDate'];?>">
					</div>
				</div> -->
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">Service:</label>
					</div>
					<div class="col-sm-10">
                    <select   name="service" id="specialization" class="form-control" required>
                    <option selected hidden><?php echo $row['Specialization'];?></option>
                    <?php
$sql="SELECT * FROM tblspecialization";
$stmt=$dbh->query($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while($row =$stmt->fetch()) { 
  ?>
<option value="<?php echo $row['ID'];?>"><?php echo $row['Specialization'];?></option>
<?php }?>
                    </select>
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
