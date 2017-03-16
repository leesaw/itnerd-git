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
 $i = 0;
 foreach($brand_array as $loop) {
    $i++;
    $brandname = $loop->br_name;
 }
 if ($i == 0) $brandname = "ทั้งหมด";

 $i = 0;
 foreach($shop_array as $loop) {
    $shopname = $loop->sh_name;
    $i++;
 }
 if ($i == 0) $shopname = "ทั้งหมด";


 if ($refcode == "NULL") {
    $refcode = "";
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
<td width="300"><div style="text-align: right; font-weight: bold; font-size: 16pt;">รายงานการขาย</div></td>
</tr>
<tr>
    <td>รายละเอียด : <?php echo $search_refcode; ?><br>สาขาที่ขาย : <?php echo $search_shopname; ?><br>ช่วงเวลา: <?php echo $search_startdate." ถึง ".$search_enddate; ?></td><td> </td><td> ยี่ห้อ : <?php echo $search_brandname; ?><br>วันที่พิมพ์ : <?php echo $c_date."/".$c_month."/".$c_year." ".$currenttime; ?>
    </td>
</tr>
</tbody>
</table>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="80" style="border-bottom:1px solid black;">Sold Date</th><th width="200" style="border-left:1px solid black;border-bottom:1px solid black;">Shop</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Ref. Number</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">Caseback</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">Brand</th>
    <th width="50" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">SRP</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">BAR</th><th width="30" style="border-left:1px solid black;border-bottom:1px solid black;">Discount(%)</th><th width="30" style="border-left:1px solid black;border-bottom:1px solid black;">On Top(บาท)</th>
    <th width="30" style="border-left:1px solid black;border-bottom:1px solid black;">ส่วนลดท้ายบิลรวม (บาท)</th><th width="30" style="border-left:1px solid black;border-bottom:1px solid black;">GP(%)</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Receive on Inv.</th>
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
<td width="300"><div style="text-align: right; font-weight: bold; font-size: 16pt;">รายงานการขาย</div></td>
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
        <th width="80" style="border-bottom:1px solid black;">111Sold Date</th><th width="200" style="border-left:1px solid black;border-bottom:1px solid black;">Shop</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Ref. Number</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">Caseback</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">Brand</th>
        <th width="50" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">SRP</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">BAR</th><th width="30" style="border-left:1px solid black;border-bottom:1px solid black;">Discount(%)</th><th width="30" style="border-left:1px solid black;border-bottom:1px solid black;">On Top(บาท)</th>
        <th width="30" style="border-left:1px solid black;border-bottom:1px solid black;">ส่วนลดท้ายบิลรวม (บาท)</th><th width="30" style="border-left:1px solid black;border-bottom:1px solid black;">GP(%)</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Receive on Inv.</th>
    </tr>
</thead>
<tbody>
<?php   } ?>



<tr style="border:1px solid black;"><td align="center"><?php echo $loop->so_issuedate; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo mb_substr($loop->sh_code."-".$loop->sh_name,0,30); if (strlen($loop->sh_code."-".$loop->sh_name) > 30) echo "..."; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo $loop->it_refcode; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo $loop->itse_serial_number; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo $loop->br_name; ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo $loop->soi_qty." ".$loop->it_uom; $sum_qty+=$loop->soi_qty;  ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo number_format($loop->soi_item_srp, 2, '.', ','); ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo $loop->sb_number; ?></td>
<td align="center" style="border-left:1px solid black;"><?php if($loop->soi_sale_barcode_id > 0) { $dc = $loop->sb_discount_percent; }else{ $dc = $loop->soi_dc_percent; } echo $dc; ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo $loop->soi_dc_baht; ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo $loop->so_ontop_baht; ?></td>
<td align="center" style="border-left:1px solid black;"><?php if($loop->soi_sale_barcode_id > 0) $gp = $loop->sb_gp; else $gp = $loop->soi_gp; echo $gp; ?></td>
</tr>
<td align="center" style="border-left:1px solid black;"><?php $rev = ((($loop->soi_item_srp*(100 - $dc)/100) - $loop->soi_dc_baht )*(100 -  $gp)/100); echo number_format($rev, 2, '.', ','); $sum+=$rev; ?></td>
</tr>

<?php $no++; } } ?>
<tr><td style="border-top:1px solid black;" colspan="4">&nbsp;</td><td align="right" style="border-top:1px solid black; ">จำนวนทั้งหมด</td><td align="center" style="border-top:1px solid black; border-left:1px solid black;"><?php echo $sum_qty; ?></td><td align="right" style="border-top:1px solid black; border-left:1px solid black;" colspan="6">ยอดเงินทั้งหมด</td>
  <td align="center" style="border-left:1px solid black;border-top:1px solid black;"><?php echo number_format($sum, 2, '.', ','); ?></td></tr>

</tbody>
</table>
</body>
</html>
