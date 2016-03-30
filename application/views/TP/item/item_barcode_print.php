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
<tr>
<td style="text-align: top;" width="180"><b><?php echo $loop->br_name; ?></b>
<br/>
<b><?php echo $loop->it_refcode; ?></b>
<br/>
<b><?php echo $loop->itse_serial_number; ?></b>
<br/>
<b><?php echo $loop->it_model." ".$loop->it_remark; ?></b>
<br/>
<b><?php echo $loop->it_short_description; ?></b>
</td>
<td style="text-align: top;" width="500">
<b style="font-size:16">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $loop->br_name; ?></b>
<br/>
<b style="font-size:16">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $loop->it_barcode; ?></b>
<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<barcode code='<?php echo $loop->it_barcode; ?>' type="ean13" size="1.5" height="0.3" />
<br/>
<div id="text"></div>
<b style="font-size:16">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($loop->it_srp)." THB"; ?></b>
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