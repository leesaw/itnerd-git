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
<tr><td style="text-align: top;" width="30"></td>
<td style="text-align: top; font-size:16pt" width="200"><b><?php echo $result_array[$i]['br_name']; ?></b>
<br/>
<b><?php echo $result_array[$i]['it_refcode']; ?></b>
<br/>
<b><?php echo $result_array[$i]['it_srp']." THB"; ?></b>
</td>
<td style="text-align: top;" width="500">
<b style="font-size:16pt">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result_array[$i]['it_refcode']; ?></b>
<br/>
<barcode code='<?php echo $result_array[$i]['it_refcode']; ?>' type="C128a" size="0.9" height="1.2" />
<br/>
<!-- <b >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result_array[$i]['it_refcode']; ?></b>
<br/> -->
<b style="font-size:16pt">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($result_array[$i]['it_srp'])." THB"; ?></b>
</td>
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
<script src="<?php echo base_url(); ?>plugins/jquery-barcode.min.js"></script>
</body>
</html>
