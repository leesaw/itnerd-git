<!DOCTYPE html>
<html>
<head>
<title>POS Printing</title>
</head>
<body>
<?php
$count = count($result_array);
for($i = 0; $i<$count; $i++) {
	for($j=0; $j<$result_array[$i]['it_qty']; $j++) {
?>
<table border="0">
<tbody>
<tr>
<td style="text-align: top; font-size:16pt" width="235"><b><?php echo $result_array[$i]['br_name']; ?></b>
</td>
<td style="text-align: top; font-size:16pt" colspan="2">
<b><?php echo $result_array[$i]['it_refcode']; ?></b>
</td>
</tr>
<tr>
<td style="text-align: top; font-size:16pt"><b><?php echo $result_array[$i]['it_refcode']; ?></b></td>
<td style="text-align: top;" width="80"><barcode code="<?php echo $result_array[$i]['it_refcode']; ?>" type="QR" class="barcode" size="0.4" /></td>
<td style="text-align: top;" width="400"><b style="font-size:16pt"><?php echo number_format($result_array[$i]['it_srp'])." THB"; ?></b></td>
</tr>
<tr>
<td style="text-align: top; font-size:16pt"><b><?php echo number_format($result_array[$i]['it_srp'])." THB"; ?></b></td>
<td></td>
<td></td>
</tr>
</tbody>
</table>
<?php if ($j != $result_array[$i]['it_qty']-1) { ?>
<pagebreak />
<?php
} }

if ($i != $count-1) { ?>
<pagebreak />
<?php } } ?>
</body>
</html>
