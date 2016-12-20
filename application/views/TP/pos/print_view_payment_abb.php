<!DOCTYPE html>
<html>
<head>
<title>Invoice ABB Printing</title>
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
		<th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">เลขที่ใบกำกับภาษีอย่างย่อ</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">สถานะ</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">วันที่ออก</th><th width="200" style="border-left:1px solid black;border-bottom:1px solid black;">POS</th>
    <th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">พนักงานขาย</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">ลูกค้า</th>
    <th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">รวมส่วนลด</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">ส่วนลดท้ายบิล</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">ภาษีมูลค่าเพิ่ม</th>
    <th width="120" style="border-left:1px solid black;border-bottom:1px solid black;">รวมยอดเงิน<br>(รวมภาษี)</th>
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
		<th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">เลขที่ใบกำกับภาษีอย่างย่อ</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">สถานะ</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">วันที่ออก</th><th width="200" style="border-left:1px solid black;border-bottom:1px solid black;">POS</th>
    <th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">พนักงานขาย</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">ลูกค้า</th>
    <th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">รวมส่วนลด</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">ส่วนลดท้ายบิล</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">ภาษีมูลค่าเพิ่ม</th>
    <th width="120" style="border-left:1px solid black;border-bottom:1px solid black;">รวมยอดเงิน<br>(รวมภาษี)</th>
	</tr>
</thead>
<tbody>
<?php   } ?>



<tr style="border:1px solid black;"><td align="center"><?php echo $loop->posp_small_invoice_number; ?></td>
<td style="border-left:1px solid black;" align="center"><?php if ($loop->posp_status == 'V') $status="ยกเลิก(Void)"; else if($loop->posp_status == 'T') $status="เปลี่ยนเป็นใบกำกับภาษีแบบเต็มแล้ว"; else $status = "ปกติ"; echo $status; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo $loop->posp_issuedate; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo $loop->posh_name; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo $loop->nggu_firstname." ".$loop->nggu_lastname; ?></td>
<td style="border-left:1px solid black;" align="center"><?php echo $loop->posc_name; ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo number_format($loop->posp_price_discount, 2, '.', ','); ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo number_format($loop->posp_price_topup, 2, '.', ','); ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo number_format($loop->posp_price_tax, 2, '.', ','); ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo number_format($loop->net, 2, '.', ','); $sum+=$loop->net; ?></td>
</tr>

<?php $no++; } } ?>
<tr><td style="border-top:1px solid black;" colspan="8">&nbsp;</td><td align="right" style="border-top:1px solid black; ">ยอดรวมทั้งหมด</td><td align="center" style="border-top:1px solid black; border-left:1px solid black;"><?php echo $sum; ?></td></tr>

</tbody>
</table>
</body>
</html>
