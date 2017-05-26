<!DOCTYPE html>
<html>
<head>
<title>Return Confirm Printing</title>
</head>
<body>
<table border="0">
<tbody>
<tr>
<td width="450">
<div style="text-align: left; font-weight: bold; font-size: 20pt;">NGG TIMEPIECES COMPANY LIMITED</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">27 Soi Pattanasin Naradhiwas Rajanagarindra Rd. Thungmahamek Sathon Bangkok 10120</div>
</td>
<td width="50"> </td>
<td width="200"><div style="text-align: right; font-weight: bold; font-size: 16pt;">ใบรายการรับคืนสินค้า</div></td>
</tr>
<?php foreach($detail_array as $loop) { $datetime = $loop->stor_issue; $warehouse = $loop->wh_code_in." - ".$loop->wh_name_in; $so_number = $loop->so_number; $stor_number = $loop->stor_number; $editor = $loop->firstname." ".$loop->lastname;
  $confirmer = $loop->firstname_confirm." ".$loop->lastname_confirm; $dateadd = $loop->stor_confirm_dateadd; $remark = $loop->stor_remark; break; }

 $GGyear=substr($datetime,0,4);
 $GGmonth=substr($datetime,5,2);
 $GGdate=substr($datetime,8,2);

 $dateadd = substr($dateadd,8,2)."/".substr($dateadd,5,2)."/".substr($dateadd,0,4)." ".substr($dateadd,11,8);
?>
<tr>
    <td>เลขที่ใบสั่งขายที่ต้องการคืน : <?php echo $so_number; ?><br>คลังที่รับคืน : <?php echo $warehouse; ?><br>ชื่อผู้ขอคืน:  <?php echo $editor; ?><br>Remark: <?php echo $remark; ?></td><td> </td><td>เลขที่ <?php echo $stor_number; ?><br> วันที่ : <?php echo $GGdate."/".$GGmonth."/".$GGyear; ?><br>ชื่อผู้รับคืน : <?php echo $confirmer; ?><br>วันที่ยืนยัน : <?php echo $dateadd; ?>
    </td>
</tr>
</tbody>
</table>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="30" style="border-bottom:1px solid black;">No.</th><th width="340" style="border-left:1px solid black;border-bottom:1px solid black;">Ref. Number/รายละเอียดสินค้า</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน<br>ที่รับคืน</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">หน่วยละ</th><th width="120" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวนเงิน</th>
	</tr>
</thead>
<tbody>
<?php $no=1; $sum=0; $sum_in=0; if(isset($request_array)) { foreach($request_array as $loop) { ?>
<tr style="border:1px solid black;"><td align="center"><?php echo $no; ?></td>
<td style="border-left:1px solid black;"><?php echo $loop->it_refcode."&nbsp; / &nbsp;".$loop->br_name." ".$loop->it_model; ?>
</td>
<td align="center" style="border-left:1px solid black;"><?php echo $loop->qty_final." &nbsp; ".$loop->it_uom; ?></td>
<td align="right" style="border-left:1px solid black;"><?php echo number_format($loop->it_srp, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
<td align="right" style="border-left:1px solid black;"><?php echo number_format($loop->qty_final*$loop->it_srp, 2, '.', ',')."&nbsp;&nbsp;"; $sum += $loop->qty_final*$loop->it_srp; $sum_in += $loop->qty_final; ?></td>
</tr>
<?php
// print serial number
if(isset($serial_array)) {
    foreach ($serial_array as $loop2) {
        if (($loop->log_stor_item_id==$loop2->log_stor_item_id) && (!is_null($loop2->itse_serial_number))) { ?>
<tr style="border:1px solid black;"><td align="center"></td>
<td style="border-left:1px solid black;"><?php echo "Caseback : ".$loop2->itse_serial_number; ?>
</td>
<td align="center" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
</tr>
    <?php
        }
    }
}
?>
<?php $no++; } } ?>
<tr><td style="border-top:1px solid black;">&nbsp;</td><td align="right" style="border-top:1px solid black; border-left:1px solid black;">รวมจำนวน</td><td align="center" style="border-top:1px solid black; border-left:1px solid black;"><?php echo $sum_in; ?></td><td align="right" style="border-top:1px solid black; border-left:1px solid black;">รวมเงิน</td><td align="right" style="border-left:1px solid black;border-top:1px solid black;"><?php echo number_format($sum, 2, '.', ',')."&nbsp;&nbsp;"; ?></td></tr>

</tbody>
</table>
</body>
</html>
