<!DOCTYPE html>
<html>
<head>
<title>POS Printing</title>
</head>
<body>
<?php 
$count = count($serial_array);
$i = 0;
foreach($serial_array as $loop) { ?>
<table border="0">
<tbody>
<tr><td style="text-align: top;" width="40"></td>
<td style="text-align: top;" width="200"><b><?php echo $loop->br_name; ?></b>
<br/>
<b><?php echo $loop->it_refcode; ?></b>
<br/>
<b><?php echo $loop->itse_serial_number; ?></b>
<br/>
<b><?php echo $loop->it_model; ?></b>
</td>
<td style="text-align: top;" width="500">
<b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $loop->br_name." ".$loop->it_refcode; ?></b>
<br/>
<b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $loop->itse_serial_number; ?></b>
<br/>
<barcode code='<?php echo $loop->itse_serial_number; ?>' type="C39" size="0.8" height="1" class='barcode' />
<br/>
<div id="text"></div>
<b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($loop->it_srp)." THB"; ?></b>
</td>
</tr>
</tbody>
</table>
<?php $i++; if ($i != $count) { ?>
<pagebreak />
<?php } } ?>
<script src="<?php echo base_url(); ?>plugins/jquery-barcode.min.js"></script>
</body>
</html>