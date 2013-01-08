<?php echo gButton_to_function(__("Delete"), "do_batch('delete')", array('class'=>'batch delete action-clear', 'confirm'=>__('Are you sure?'))) ?>
<?php echo gButton_to_function(__("Print"), "", 'class=batch print action-clear rel=print:html') ?>
<?php echo gButton_to_function(__("PDF"), "", 'class=batch pdf action-clear rel=print:pdf') ?>
<?php echo gButton_to_function(__("Send"), "", 'class=batch send action-clear rel=batch:email') ?>
<?php echo gButton_to_function(__("Export"), "", 'class=batch export action-clear rel=export') ?>
<?php echo gButton_to_function(__("Remit"), "", 'class=batch remesar action-clear rel=remesar') ?>
