<div class="modal fade" id="delete_<?php echo $row['InvoiceNumber']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Invoice</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">Are you sure you want to delete <strong style="text-transform: uppercase;"><?php echo $row['PatientName']; ?></strong> Invoice?</p>
                <h2 class="text-center">Invoice Number <br/> <?php echo $row['InvoiceNumber']; ?></h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Cancel</button>
                <a href="invoiceDeleteQuery.php?InvoiceNumber=<?php echo $row['InvoiceNumber']; ?>" class="btn btn-danger"><span class='glyphicon glyphicon-trash'></span>Yes</a>
            </div>
        </div>
    </div>
</div>