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
<td style="text-align: top;" width="200"><b><?php echo $loop->br_name." ".$loop->itse_serial_number; ?></b>
<br/>
<b><?php echo $loop->it_refcode; ?></b>
<br/>
<b><?php echo $loop->it_model." ".$loop->it_remark; ?></b>
<br/>
<b style="font-size:12"><?php echo $loop->it_short_description; ?></b>
</td>
<td style="text-align: top;" width="500">
<b style="font-size:12">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $loop->br_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($loop->itse_qms > 0) echo "Q"; ?></b>
<br/>
<b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $loop->itse_serial_number; ?></b>
<br/>
<barcode code='<?php echo $loop->itse_serial_number; ?>' type="C128a" size="1" height="0.8" class='barcode' />
<br/>
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
