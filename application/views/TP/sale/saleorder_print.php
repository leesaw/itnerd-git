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
<?php foreach($so_array as $loop) { $datetime = $loop->so_issuedate; $so_id = $loop->so_number; $editor = $loop->firstname." ".$loop->lastname; $shop = $loop->sh_code."-".$loop->sh_name; break; } 

 $GGyear=substr($datetime,0,4); 
 $GGmonth=substr($datetime,5,2); 
 $GGdate=substr($datetime,8,2); 
?>
<td width="50"> </td>
<td width="200"><div style="text-align: right; font-weight: bold; font-size: 16pt;">ใบสั่งขาย</div></td>
</tr>
<tr>
    <td>เลขที่ <?php echo $so_id; ?><br>สาขาที่ขาย : <?php echo $shop; ?></td><td> </td><td> ชื่อผู้ใส่ข้อมูล:  <?php echo $editor; ?><br>วันที่ : <?php echo $GGdate."/".$GGmonth."/".$GGyear; ?>
    </td>
</tr>
</tbody>
</table>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="30" style="border-bottom:1px solid black;">No.</th><th width="150" style="border-left:1px solid black;border-bottom:1px solid black;">Ref. Number</th><th width="250" style="border-left:1px solid black;border-bottom:1px solid black;">รายละเอียดสินค้า</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">หน่วยละ</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">Barcode</th><th width="140" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวนเงิน</th>
	</tr>
</thead>
<tbody>
<?php $no=1; $sum=0; $sum_qty=0; if(isset($item_array)) { foreach($item_array as $loop) { 
?>
<tr style="border:1px solid black;"><td align="center"><?php echo $no; ?></td>
<td style="border-left:1px solid black;"><?php echo $loop->it_refcode; ?></td>
<td style="border-left:1px solid black;"><?php echo $loop->br_name." ".$loop->it_model; ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo $loop->soi_qty." ".$loop->it_uom; ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo number_format($loop->it_srp, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo $loop->sb_number; ?></td>
<td align="right" style="border-left:1px solid black;"><?php $cal = ($loop->soi_qty*$loop->it_srp)*((100-$loop->sb_discount_percent)/100)*((100-$loop->sb_gp)/100); echo number_format($cal, 2, '.', ',')."&nbsp;&nbsp;"; $sum += $cal; $sum_qty += $loop->soi_qty; ?></td>
</tr>
<?php
// print serial number
if(isset($serial_array)) {
    foreach ($serial_array as $loop2) {
        if ($loop->soi_item_id==$loop2->sos_item_id) { ?>
<tr style="border:1px solid black;"><td align="center"></td>
<td align="center" style="border-left:1px solid black;"></td>
<td style="border-left:1px solid black;"><?php echo "Caseback : ".$loop2->itse_serial_number; ?>   
</td>
<td align="center" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
</tr>
    <?php
        }
    }
}
?> 
<?php $no++; } } ?> 
<tr><td style="border-top:1px solid black;" colspan="2">&nbsp;</td><td align="right" style="border-top:1px solid black; ">รวมจำนวน</td><td align="center" style="border-top:1px solid black; border-left:1px solid black;"><?php echo $sum_qty; ?></td><td align="right" style="border-top:1px solid black; border-left:1px solid black;" colspan="2">รวมเงิน</td><td align="right" style="border-left:1px solid black;border-top:1px solid black;"><?php echo number_format($sum, 2, '.', ',')."&nbsp;&nbsp;"; ?></td></tr>

</tbody>
</table>
<table style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr><td width="350" align="center">ผู้ใส่ข้อมูล</td><td width="350" align="center">ผู้อนุมัติ</td>
</tr>
<tr><td> </td><td>&nbsp;</td></tr>
<tr><td align="center">..........................................................</td><td align="center">  &nbsp;&nbsp;&nbsp; ..........................................................</td>
</tr>
<tr><td align="center"><?php echo $editor; ?></td><td> &nbsp;</td></tr>
<tbody>
</table>
</body>
</html>