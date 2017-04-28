<!DOCTYPE html>
<html>
<head>
<title>Stock Transfer Printing</title>
</head>
<body>
<table border="0">
<tbody>
<tr>
<td width="450">
<div style="text-align: left; font-weight: bold; font-size: 20pt;">NGG TIMEPIECES COMPANY LIMITED</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">27 Soi Pattanasin Naradhiwas Rajanagarindra Rd. Thungmahamek Sathon Bangkok 10120</div>
</td>
<?php foreach($stock_array as $loop) { $datetime = $loop->stot_datein; $si_id = $loop->stot_number; $editor = $loop->firstname." ".$loop->lastname; $confirm = $loop->confirm_firstname." ".$loop->confirm_lastname; $stock_out = $loop->wh_out_code."-".$loop->wh_out_name; $stock_in = $loop->wh_in_code."-".$loop->wh_in_name; $status = $loop->stot_status; $stock_remark = $loop->stot_remark; $dateadd = $loop->stot_confirm_dateadd; $wh_in_group = $loop->wh_in_group; break; }

 $GGyear=substr($datetime,0,4);
 $GGmonth=substr($datetime,5,2);
 $GGdate=substr($datetime,8,2);

 $dateadd = substr($dateadd,8,2)."/".substr($dateadd,5,2)."/".substr($dateadd,0,4)." ".substr($dateadd,11,8);
?>
<td width="50"> </td>
<td width="250"><div style="text-align: right; font-weight: bold; font-size: 16pt;"><?php if ($wh_in_group == 3) echo "ใบยืนยันรับสินค้า"; else echo "ใบส่งของ"; ?></div>
<barcode code='<?php echo $si_id; ?>' type="C128A" size="1" height="0.5" class='barcode' />
</td>
</tr>
<tr>
    <td>ย้ายคลังจาก : <u><b><?php echo $stock_out; ?></b></u> ไปยัง <u><b><?php echo $stock_in; ?></b></u><br>ชื่อผู้ใส่ข้อมูล:  <?php echo $editor; ?><br>Remark: <?php if ($status==4) echo "(สวมสินค้า) "; echo $stock_remark; ?></td><td> </td><td>เลขที่ <?php echo $si_id; ?><br>วันที่กำหนดส่ง : <?php echo $GGdate."/".$GGmonth."/".$GGyear; ?><br>วันที่ยืนยัน : <?php echo $dateadd; ?>
    </td>
</tr>
</tbody>
</table>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="30" style="border-bottom:1px solid black;">No.</th><th width="150" style="border-left:1px solid black;border-bottom:1px solid black;">Ref. Number</th><th width="250" style="border-left:1px solid black;border-bottom:1px solid black;">รายละเอียดสินค้า</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">หน่วยละ</th><th width="140" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวนเงิน</th>
	</tr>
</thead>
<tbody>
<?php $no=1; $sum=0; $sum_qty=0; $count_row=0; if(isset($stock_array)) { foreach($stock_array as $loop) {
if ($loop->qty_final > 0) {
?>
<?php if (($count_row !=0) && (($count_row%36) == 0)) { ?></tbody></table><pagebreak /><table border="0">
<tbody>
<tr>
<td width="450">
<div style="text-align: left; font-weight: bold; font-size: 20pt;">NGG TIMEPIECES COMPANY LIMITED</div><br\><div style="text-align: left; font-weight: font-size: 16pt;">27 Soi Pattanasin Naradhiwas Rajanagarindra Rd. Thungmahamek Sathon Bangkok 10120</div>
</td>
<td width="50"> </td>
<td width="200"><div style="text-align: right; font-weight: bold; font-size: 16pt;"><?php if ($wh_in_group == 3) echo "ใบยืนยันรับสินค้า"; else echo "ใบส่งของ"; ?></div></td>
</tr>
<tr>
    <td>ย้ายคลังจาก : <u><b><?php echo $stock_out; ?></b></u> ไปยัง <u><b><?php echo $stock_in; ?></b></u><br>ชื่อผู้ใส่ข้อมูล:  <?php echo $editor; ?><br>Remark: <?php if ($status==4) echo "(สวมสินค้า) "; echo $stock_remark; ?></td><td> </td><td>เลขที่ <?php echo $si_id; ?><br>วันที่กำหนดส่ง : <?php echo $GGdate."/".$GGmonth."/".$GGyear; ?><br>วันที่ยืนยัน : <?php echo $dateadd; ?>
    </td>
</tr>
</tbody>
</table>
<table style="border:1px solid black; border-spacing:0px 0px;">
<thead>
	<tr>
		<th width="30" style="border-bottom:1px solid black;">No.</th><th width="150" style="border-left:1px solid black;border-bottom:1px solid black;">Ref. Number</th><th width="250" style="border-left:1px solid black;border-bottom:1px solid black;">รายละเอียดสินค้า</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวน</th><th width="100" style="border-left:1px solid black;border-bottom:1px solid black;">หน่วยละ</th><th width="140" style="border-left:1px solid black;border-bottom:1px solid black;">จำนวนเงิน</th>
	</tr>
</thead>
<tbody>
<?php } ?>
<tr style="border:1px solid black;"><td align="center"><?php echo $no; ?></td>
<td style="border-left:1px solid black;"><?php echo $loop->it_refcode; ?></td>
<td style="border-left:1px solid black;"><?php
if ($loop->br_id != '896') echo $loop->br_name." ".$loop->it_model;
else echo $loop->br_name." ".$loop->it_short_description; ?></td>
<td align="center" style="border-left:1px solid black;"><?php echo $loop->qty_final." &nbsp; ".$loop->it_uom; ?></td>
<td align="right" style="border-left:1px solid black;"><?php echo number_format($loop->it_srp, 2, '.', ',')."&nbsp;&nbsp;"; ?></td>
<td align="right" style="border-left:1px solid black;"><?php echo number_format($loop->qty_final*$loop->it_srp, 2, '.', ',')."&nbsp;&nbsp;"; $sum += $loop->qty_final*$loop->it_srp; $sum_qty += $loop->qty_final; ?></td>
</tr>
<?php
// print serial number
$count_row++;
if(isset($serial_array)) {
    foreach ($serial_array as $loop2) {
        if ($loop->log_stot_item_id==$loop2->itse_item_id) { ?>
<tr style="border:1px solid black;"><td align="center"></td>
<td align="center" style="border-left:1px solid black;"></td>
<td style="border-left:1px solid black;"><?php echo "Caseback : ".$loop2->itse_serial_number; if ($loop2->itse_sample == 1) echo "(Sample)"; ?>
</td>
<td align="center" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
<td align="right" style="border-left:1px solid black;"></td>
</tr>
    <?php
       $count_row++; }
    }
}
?>
<?php $no++; } } } ?>
<tr><td style="border-top:1px solid black;">&nbsp;</td><td style="border-top:1px solid black;">&nbsp;</td><td align="right" style="border-top:1px solid black; border-left:1px solid black;">รวมจำนวน</td><td align="center" style="border-top:1px solid black; border-left:1px solid black;"><?php echo $sum_qty; ?></td><td align="right" style="border-top:1px solid black; border-left:1px solid black;">รวมเงิน</td><td align="right" style="border-left:1px solid black;border-top:1px solid black;"><?php echo number_format($sum, 2, '.', ',')."&nbsp;&nbsp;"; ?></td></tr>

</tbody>
</table>
<table style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr><td width="350" align="center">ผู้ส่งสินค้า</td><td width="350" align="center">ผู้รับสินค้า</td>
</tr>
<tr><td> </td><td>&nbsp;</td></tr>
<tr><td align="center">..........................................................</td><td align="center">  &nbsp;&nbsp;&nbsp; ..........................................................</td>
</tr>
<tr><td align="center"> &nbsp;</td><td> &nbsp;</td></tr>
<tbody>
</table>
</body>
</html>
