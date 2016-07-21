<!DOCTYPE html>
<html>
<head>
<title>Report</title>
<style>
table {
    border-collapse: collapse;
}


</style>
</head>
<body>
<?php $page_number=1; ?>
<table border="0">
<tbody>
<tr>
<td width="150"><img src="<?php echo base_url(); ?>dist/img/logo_NGG.png" width="150px" />
</td> 
<td width="800" style="text-align: center;"><div style="font-weight: bold; font-size: 16pt;">รายงานประเมินและเป้าหมายการขาย<br>Monthly Target <u><?php echo number_format($daily_target); ?></u> เดือน : <u><?php echo $month; ?></u> พนักงานขาย : <u><?php echo $salename; ?></u> สาขา : <u><?php echo $shopname; ?></u></div></td>
<td width="150" style="text-align: right;">หน้าที่ <?php echo $page_number ?></td>
</tr>
</tbody>
</table>

<table border="1" style="text-align:center">
<tbody>
<tr>
    <th width="80" rowspan="2">วันที่</th>
    <th colspan="3">เป้าการขายประจำวัน</th>
    <th width="80" rowspan="2">จำนวนลูกค้า</th>
    <th width="80" rowspan="2">จำนวนสินค้า</th>
    <th width="100" rowspan="2">ยอดขายประจำวัน</th>
    <th colspan="3">สินค้าที่ขายได้</th>
    <th colspan="3">ผลสรุปทำสำเร็จ<br>คิดเป็นเปอร์เซ็นต์</th>
</tr>
<tr>
	<th width="100">จำนวนเงิน</th>
	<th width="80">จำนวนสินค้า</th>
	<th width="80">จำนวนลูกค้า</th>

	<th width="100">รหัสสินค้า</th>
	<th width="150">จำนวนเงิน</th>
	<th width="80">จำนวนสินค้า</th>

	<th width="80">เป้าหมายต่อวัน</th>
	<th width="80">ลูกค้าที่ซื้อ</th>
	<th width="80">ยอดขาย</th>
</tr>
<?php 
$sum_customer = 0;
$sum_gold = 0;
$sum_price = 0;
$sum_date = 0;
$sum_product = 0;
$count_row = 0;

foreach($day_array as $loop) { ?>

<?php  if (($count_row !=0) && (($count_row%30) == 0)) { $page_number++; ?></tbody></table><pagebreak />
<table border="0">
<tbody>
<tr>
<td width="150"><img src="<?php echo base_url(); ?>dist/img/logo_NGG.png" width="150px" />
</td> 
<td width="800" style="text-align: center;"><div style="font-weight: bold; font-size: 16pt;">รายงานประเมินและเป้าหมายการขาย<br>Monthly Target <u><?php echo number_format($daily_target); ?></u> เดือน : <u><?php echo $month; ?></u> พนักงานขาย : <u><?php echo $salename; ?></u> สาขา : <u><?php echo $shopname; ?></u></div></td>
<td width="150" style="text-align: right;">หน้าที่ <?php echo $page_number ?></td>
</tr>
</tbody>
</table>
<table border="1" style="text-align:center">
<tbody>
<tr>
    <th width="80" rowspan="2">วันที่</th>
    <th colspan="3">เป้าการขายประจำวัน</th>
    <th width="80" rowspan="2">จำนวนลูกค้า</th>
    <th width="80" rowspan="2">จำนวนสินค้า</th>
    <th width="100" rowspan="2">ยอดขายประจำวัน</th>
    <th colspan="3">สินค้าที่ขายได้</th>
    <th colspan="3">ผลสรุปทำสำเร็จ<br>คิดเป็นเปอร์เซ็นต์</th>
</tr>
<tr>
	<th width="100">จำนวนเงิน</th>
	<th width="80">จำนวนสินค้า</th>
	<th width="80">จำนวนลูกค้า</th>

	<th width="100">รหัสสินค้า</th>
	<th width="150">จำนวนเงิน</th>
	<th width="80">จำนวนสินค้า</th>

	<th width="80">เป้าหมายต่อวัน</th>
	<th width="80">ลูกค้าที่ซื้อ</th>
	<th width="80">ยอดขาย</th>
</tr>


<?php  } ?>
<tr>
	<td><?php echo $loop->ngw_issuedate; $sum_date++; ?></td>
	<td><?php echo $daily_target; ?></td>
	<td><?php echo $daily_product; ?></td>
	<td><?php echo $daily_customer; ?></td>
	<td><?php echo $loop->count_customer; $sum_customer+=$loop->count_customer; ?></td>
	<td><?php echo $loop->count_gold; $sum_gold+=$loop->count_gold; ?></td>
	<td><?php echo number_format($loop->sum_price, 2, '.', ','); $sum_price += $loop->sum_price; ?></td>

<?php $daily_count = 0; foreach($item_array as $loop2) { if ($loop->ngw_issuedate == $loop2->ngw_issuedate) { 

		$daily_count++;
		$count_row++;
?>

<?php	if($daily_count == 2) {
?>
		<td><?php echo "100%"; ?></td>
		<td><?php $customer_percent = ($loop->count_customer/$daily_customer)*100;
	        echo $customer_percent."%";
	    ?></td>
	    <td><?php 
	        $price_percent = ($loop->sum_price/$daily_target)*100;
	        echo $price_percent."%";
	     ?></td>
	</tr>
	<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>

<?php   }elseif ($daily_count > 2){  ?>

		<td></td>
		<td></td>
	    <td></td>
	</tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>

<?php } ?>
	<td><?php echo $loop2->ngw_code; ?></td>
	<td><?php echo number_format($loop2->ngw_price, 2, '.', ','); ?></td>
	<td><?php echo "1"; ?></td>


<?php } } if ($daily_count==1) { ?>

	<td><?php echo "100%"; ?></td>
		<td><?php $customer_percent = ($loop->count_customer/$daily_customer)*100;
	        echo $customer_percent."%";
	    ?></td>
	    <td><?php 
	        $price_percent = ($loop->sum_price/$daily_target)*100;
	        echo $price_percent."%";
	     ?></td>
	</tr>

<?php }elseif ($daily_count>1) { ?>
		<td></td><td></td><td></td></tr>

<?php } } ?>
<tr>
	<th colspan="4">ยอดรวมประจำเดือน</th>
	<th><?php echo $sum_customer; ?></th>
	<th><?php echo $sum_gold; ?></th>
	<th><?php echo number_format($sum_price, 2, '.', ','); ?></th>
	<th></th><th></th><th></th><th>100%</th>
	<th><?php if ($sum_date > 0) { $sum_customer_percent = ($sum_customer/($sum_date*$daily_customer))*100; }else{ $sum_customer_percent = 0; }
        echo number_format($sum_customer_percent, 2, '.', ',')."%"; ?></th>
	<th><?php if ($sum_date > 0) { $sum_price_percent = ($sum_price/($sum_date*$daily_target))*100; }else{ $sum_price_percent = 0; }
        echo number_format($sum_price_percent, 2, '.', ',')."%"; ?></th>
</tr>
</tbody>
</table>
</body>
</html>