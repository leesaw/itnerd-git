<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>
<table class="table table-bordered">
<tr><th>Caseback Number</th></tr>
<?php foreach($serial_array as $loop) { ?>
<tr><td><?php echo $loop->itse_serial_number; ?></td>
</tr>    
<?php } ?>
</table>
</body>
</html>