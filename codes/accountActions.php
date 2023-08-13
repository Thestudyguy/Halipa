<div  class="modal fade" id="edit_<?php echo $row['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="editModalLabel-<?php echo $row['Email']; ?>">Edit Entry</h4>
                </div>
                <div class="modal-body">
                    <!-- Input fields inside the modal -->
                    <form method="POST" action="accountEdit.php">
                      <legend><strong><?php echo $row['FullName']; ?></strong></legend>
    <div class="form-group">
        <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">
        <label for="fullName">Full Name:</label>
        <input type="text" class="form-control"  name="editfullname" value="<?php echo $row['FullName']; ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Mobile Number:</label>
        <input type="number" class="form-control"  name="editNumber" value="<?php echo $row['MobileNumber']; ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control"  name="editemail" value="<?php echo $row['Email']; ?>" required>
    </div>
    <div class="form-group">
        <label for="current_password">Password:</label>
        <input type="text" name="password" class="form-control" value="<?php echo $row['Password']; ?>" required>
    </div>
    <div class="form-group">
        <label for="access">Account Privilege:</label>
        <select class="form-control" name="editaccess" required>
            <option value="" selected hidden>Select Account Privilege</option>
            <option value="Admin Access" <?php echo ($row['Access'] == 'Admin Access') ? 'selected' : ''; ?>>Admin Access</option>
            <option value="View Only" <?php echo ($row['Access'] == 'View Only') ? 'selected' : ''; ?>>View Only</option>
        </select>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Save</button>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>

    <!-- delete modal -->
    <div class="modal fade" id="delete_<?php echo $row['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Delete Patient Record</h4></center>
            </div>
            <div class="modal-body">	
            	<p class="text-center">Are you sure you want to Delete</p>
				<h2 class="text-center"><?php echo $row['FullName']?></h2>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <a href="deleteAccount.php?accountid=<?php echo $row['ID']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Yes</a>
            </div>

        </div>
    </div>
</div>
