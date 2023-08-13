<div class="modal fade" id="modal-<?php echo $row['AppointmentNumber']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Appointment</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">Are you sure you want to delete <strong style="text-transform: uppercase;"><?php echo $row['Name']; ?></strong> appointment?</p>
                <h2 class="text-center">Appointment Number <br/> <?php echo $row['AppointmentNumber']; ?></h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Cancel</button>
                <a href="deleteAppointments.php?AppointmentNumber=<?php echo $row['AppointmentNumber']; ?>" class="btn btn-danger" ><span class='glyphicon glyphicon-trash'></span>Yes</a>
            </div>
        </div>
    </div>
</div>