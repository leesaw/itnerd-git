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
<td style="text-align: top; font-size:16pt" width="235"><b><?php echo $loop->br_name; ?></b>
</td>
<td style="text-align: top; font-size:16pt" colspan="2">
<b><?php echo $loop->it_refcode; ?></b>
</td>
</tr>
<tr>
<td style="text-align: top; font-size:16pt"><b><?php echo $loop->it_refcode; ?></b></td>
<td style="text-align: top;" width="80"><barcode code="<?php echo $loop->itse_serial_number; ?>" type="QR" class="barcode" size="0.4" /></td>
<td style="text-align: top;" width="400"><b style="font-size:14pt"><?php echo $loop->itse_serial_number; ?></b></td>
</tr>
<tr>
<td style="text-align: top; font-size:16pt"><b><?php echo $loop->itse_serial_number; ?></b></td>
<td></td>
<td style="text-align: top; font-size:16pt"><b><?php echo number_format($loop->it_srp)." THB"; ?></b></td>
</tr>
</tbody>
</table>
<?php $i++; if ($i != $count) { ?>
<pagebreak />
<?php } } ?>
<script src="<?php echo base_url(); ?>plugins/jquery-barcode.min.js"></script>
</body>
</html>
