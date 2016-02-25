<!DOCTYPE html>
<html>
<head>
<title>Stock In Printing</title>
</head>
<body>
<table border="0">
<tbody>
<tr>
<td width="450">
<div style="text-align: left; font-weight: bold; font-size: 20pt;">NGG TIMEPIECES COMPANY LIMITED</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">27 Soi Pattanasin Naradhiwas Rajanagarindra Rd. Thungmahamek Sathon Bangkok 10120</div>
</td> 
<td width="50"> </td>
<td width="200"><div style="text-align: right; font-weight: bold; font-size: 16pt;">ใบรายการสินค้ารับเข้าคลัง</div></td>
</tr>
<?php foreach($stock_array as $loop) { $datetime = $loop->stoi_datein; $si_id = $loop->stoi_number; $editor = $loop->firstname." ".$loop->lastname; $stock_name = $loop->wh_code."-".$loop->wh_name; break; } 

 $GGyear=substr($datetime,0,4); 
 $GGmonth=substr($datetime,5,2); 
 $GGdate=substr($datetime,8,2); 
?>
<tr>
    <td>เลขที่ <?php echo $si_id; ?><br>คลังที่รับเข้า : <?php echo $stock_name; ?></td><td> </td><td> ชื่อผู้ใส่ข้อมูล:  <?php echo $editor; ?><br>วันที่ : <?php echo $GGdate."/".$GGmonth."/".$GGyear; ?>
    </td>
</tr>
</tbody>
</table>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="30" style="border-bottom:1px solid black;">No.</th><th width="280" style="border-left:1px solid black;border-bottom:1px solid black;">Ref. Number/รายละเอียดสินค้า</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน<br>ในคลัง</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน<br>รับเข้า</th><th width="80" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน<br>ในคลังหลังรับเข้า</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">หน่วยละ</th><th width="120" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวนเงิน</th>
	</tr>
</thead>
<tbody>
<?php $no=1; $sum=0; $sum_in=0; if(isset($stock_array)) { foreach($stock_array as $loop) { ?>
<tr style="border:1px solid black;"><td align="center"><?php echo $no; ?></td>
<td style="border-left:1px solid black;"><?php echo $loop->it_refcode."&nbsp; / &nbsp;".$loop->br_name." ".$loop->it_model; ?>   
</td>
<td align="center" style="border-left:1px solid black;"><?php echo $loop->qty_old." &nbsp; ".$loop->it_uom; ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo $loop->qty_update." &nbsp; ".$loop->it_uom; ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo ($loop->qty_old+$loop->qty_update)." &nbsp; ".$loop->it_uom; ?></td>
<td align="right" style="border-left:1px solid black;"><?php echo number_format($loop->it_srp, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
<td align="right" style="border-left:1px solid black;"><?php echo number_format($loop->qty_update*$loop->it_srp, 2, '.', ',')."&nbsp;&nbsp;"; $sum += $loop->qty_update*$loop->it_srp; $sum_in += $loop->qty_update; ?></td>
</tr>
<?php
// print serial number
if(isset($serial_array)) {
    foreach ($serial_array as $loop2) {
        if ($loop->log_stob_item_id==$loop2->log_stob_item_id) { ?>
<tr style="border:1px solid black;"><td align="center"></td>
<td style="border-left:1px solid black;"><?php echo "Caseback : ".$loop2->itse_serial_number; ?>   
</td>
<td align="center" style="border-left:1px solid black;"></td>
<td align="center" style="border-left:1px solid black;"></td>
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
<tr><td style="border-top:1px solid black;">&nbsp;</td><td style="border-top:1px solid black;">&nbsp;</td><td align="right" style="border-top:1px solid black; border-left:1px solid black;">รวมจำนวน</td><td align="center" style="border-top:1px solid black; border-left:1px solid black;"><?php echo $sum_in; ?></td><td style="border-left:1px solid black;border-top:1px solid black;">&nbsp;</td><td align="right" style="border-top:1px solid black;">รวมเงิน</td><td align="right" style="border-left:1px solid black;border-top:1px solid black;"><?php echo number_format($sum, 2, '.', ',')."&nbsp;&nbsp;"; ?></td></tr>

</tbody>
</table>
<table style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr><td width="350" align="center">ผู้รับสินค้าเข้าคลัง</td><td width="350" align="center">ผู้อนุมัติ</td>
</tr>
<tr><td> </td><td>&nbsp;</td></tr>
<tr><td align="center">..........................................................</td><td align="center">  &nbsp;&nbsp;&nbsp; ..........................................................</td>
</tr>
<tr><td> &nbsp;</td><td> &nbsp;</td></tr>
<tbody>
</table>
</body>
</html>