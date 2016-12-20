<!DOCTYPE html>
<html>
<head>
<title>Sale Order Printing</title>
</head>
<body>
<table border="0">
<tbody>
<tr>
<td width="450">
<div style="text-align: left; font-weight: bold; font-size: 20pt;">NGG TIMEPIECES COMPANY LIMITED</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">27 Soi Pattanasin Naradhiwas Rajanagarindra Rd. Thungmahamek Sathon Bangkok 10120</div>
</td>
<?php
 if ($search_refcode == "NULL") {
    $search_refcode = "";
 }
 $start_year=substr($startdate,0,4);
 $start_month=substr($startdate,5,2);
 $start_date=substr($startdate,8,2);

 $end_year=substr($enddate,0,4);
 $end_month=substr($enddate,5,2);
 $end_date=substr($enddate,8,2);

 $currentdate = date("Y-m-d");
 $c_year=substr($currentdate,0,4);
 $c_month=substr($currentdate,5,2);
 $c_date=substr($currentdate,8,2);
 $currenttime = date("H:i:s");
?>
<td width="250"> </td>
<td width="300"><div style="text-align: right; font-weight: bold; font-size: 16pt;">รายงานการขาย POS</div></td>
</tr>
<tr>
    <td>รายละเอียด : <?php echo $search_refcode; ?><br>POS ที่ขาย : <?php echo $search_shopname; ?><br>ช่วงเวลา: <?php echo $search_startdate." ถึง ".$search_enddate; ?></td><td> </td><td> ยี่ห้อ : <?php echo $search_brandname; ?><br>วันที่พิมพ์ : <?php echo $c_date."/".$c_month."/".$c_year." ".$currenttime; ?>
    </td>
</tr>
</tbody>
</table>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="80" style="border-bottom:1px solid black;">Sold Date</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">เลขที่ใบกำกับภาษีอย่างย่อ</th><th width="200" style="border-left:1px solid black;border-bottom:1px solid black;">POS</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Ref. Number</th>
    <th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Model</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">Caseback</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">Brand</th><th width="50" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">SRP</th>
    <th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Discount(บาท)</th><th width="120" style="border-left:1px solid black;border-bottom:1px solid black;">Net</th>
	</tr>
</thead>
<tbody>
<?php $no=1; $sum=0; $sum_qty=0; if(isset($item_array)) { foreach($item_array as $loop) {
?>

<?php if (($no !=0) && (($no%20) == 0)) { ?></tbody></table><pagebreak /><table border="0">
<tbody>
<tr>
<td width="450">
<div style="text-align: left; font-weight: bold; font-size: 20pt;">NGG TIMEPIECES COMPANY LIMITED</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">27 Soi Pattanasin Naradhiwas Rajanagarindra Rd. Thungmahamek Sathon Bangkok 10120</div>
</td>
<td width="250"> </td>
<td width="300"><div style="text-align: right; font-weight: bold; font-size: 16pt;">รายงานการขาย POS</div></td>
</tr>
<tr>
    <td>รายละเอียด : <?php echo $refcode; ?><br>สาขาที่ขาย : <?php echo $shopname; ?><br>ช่วงเวลา: <?php echo $startdate." ถึง ".$enddate; ?></td><td> </td><td> ยี่ห้อ : <?php echo $brandname; ?><br>วันที่พิมพ์ : <?php echo $c_date."/".$c_month."/".$c_year." ".$currenttime; ?>
    </td>
</tr>
</tbody>
</table>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
  <tr>
    <th width="80" style="border-bottom:1px solid black;">Sold Date</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">เลขที่ใบกำกับภาษีอย่างย่อ</th><th width="200" style="border-left:1px solid black;border-bottom:1px solid black;">POS</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Ref. Number</th>
    <th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Model</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">Caseback</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">Brand</th><th width="50" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">SRP</th>
    <th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Discount(บาท)</th><th width="120" style="border-left:1px solid black;border-bottom:1px solid black;">Net</th>
  </tr>
</thead>
<tbody>
<?php   } ?>



<tr style="border:1px solid black;"><td align="center"><?php echo $loop->posp_issuedate; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo $loop->posp_small_invoice_number; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo $loop->posh_name; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo $loop->it_refcode; ?></td>
<td style="border-left:1px solid black;" align="center"><?php if($loop->it_refcode!=$loop->it_model) echo $loop->it_model; else echo ""; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo $loop->popi_item_serial; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo $loop->popi_item_brand; ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo $loop->popi_item_qty." ".$loop->it_uom; $sum_qty+=$loop->popi_item_qty;  ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo number_format($loop->popi_item_srp, 2, '.', ','); ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo number_format($loop->popi_item_dc_baht, 2, '.', ','); ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo number_format($loop->popi_item_net, 2, '.', ','); ?></td>
</tr>

<?php $no++; } } ?>
<tr><td style="border-top:1px solid black;" colspan="6">&nbsp;</td><td align="right" style="border-top:1px solid black; ">จำนวนทั้งหมด</td><td align="center" style="border-top:1px solid black; border-left:1px solid black;"><?php echo $sum_qty; ?></td><td align="right" style="border-top:1px solid black; border-left:1px solid black;" colspan="3"></td></tr>

</tbody>
</table>
</body>
</html>
